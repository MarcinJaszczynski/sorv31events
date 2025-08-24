<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\EventTemplate;
use App\Http\Controllers\Admin\NotificationController;
use App\Models\Conversation;
use App\Http\Controllers\EventCsvController;
use App\Http\Controllers\EventPriceDescriptionController;

// === FRONTEND ROUTES (dodane z mergingSOR) ===
use App\Http\Controllers\Front\FrontController;
use App\Models\Place;

// Redirect old root to canonical region root using cookie (handled by middleware later)
Route::get('/', function() {
    $cookieId = request()->cookie('start_place_id');
    $slug = 'region';
    if ($cookieId && ($pl = Place::find($cookieId))) {
        $slug = \Illuminate\Support\Str::slug($pl->name);
    }
    return redirect()->route('home', ['regionSlug' => $slug]);
});

Route::group(['prefix' => '{regionSlug}', 'where' => ['regionSlug' => '[A-Za-z0-9\-]+']], function () {
    Route::post('/send-email', [FrontController::class, 'sendEmail'])->name('send-email');
    Route::get('/', [FrontController::class, 'home'])->name('home');
    Route::get('/directory-packages', [FrontController::class, 'directorypackages'])->name('directory-packages');
    Route::get('/blog', [FrontController::class, 'blog'])->name('blog');
    Route::get('/blog/{slug}', [FrontController::class, 'blogPost'])->name('blog.post');
    // public-facing packages are now under '/oferty' (Polish). Keep the route name 'packages'
    // so all existing calls to route('packages') keep working. Add a redirect from the old
    // '/packages' path to the new '/oferty' for backward compatibility.
    Route::get('/oferty', [FrontController::class, 'packages'])->name('packages');
    Route::get('/packages', function ($regionSlug) {
        return redirect()->route('packages', ['regionSlug' => $regionSlug]);
    });
    Route::get('/packages/partial', [FrontController::class, 'packagesPartial'])->name('packages.partial');
    Route::get('/package/{slug}', [FrontController::class, 'package'])->name('package');
    // Pretty package route remains the same pattern but now nested (duplicated regionSlug) -> keep original outside group
    Route::get('/insurance', [FrontController::class, 'insurance'])->name('insurance');
    Route::get('/documents', [FrontController::class, 'documents'])->name('documents');
    Route::get('/contact', [FrontController::class, 'contact'])->name('contact');
});

// SEO friendly pretty package route stays global to avoid double region slug
Route::get('/{regionSlug}/{dayLength}/{id}/{slug}', [FrontController::class, 'packagePretty'])
    ->where([
        'regionSlug' => '[A-Za-z0-9\-]+',
        'dayLength' => '[0-9]+-dniowe',
        'id' => '[0-9]+',
        'slug' => '[A-Za-z0-9\-]+'
    ])
    ->name('package.pretty');


// Import/eksport CSV dla Eventów
Route::get('/events/export-csv', [EventCsvController::class, 'export'])->name('events.export.csv');
Route::post('/events/import-csv', [EventCsvController::class, 'import'])->name('events.import.csv');

Route::get('/test-log', function () {
    Log::info('Test route accessed at ' . now());
    return 'Test log written - check storage/logs/laravel.log';
});

Route::get('/test-drag-drop', function () {
    Log::info('Testing drag & drop functionality');
    
    try {
        // Znajdź pierwszy event template
        $eventTemplate = EventTemplate::first();
        if (!$eventTemplate) {
            return 'No event template found';
        }
        
        // Utwórz instancję komponentu
        $kanban = new \App\Filament\Resources\EventTemplateResource\Widgets\EventProgramKanban();
    $kanban->record = $eventTemplate;
        
        // Sprawdź, czy są jakieś punkty programu
        $pivotRecords = \Illuminate\Support\Facades\DB::table('event_template_event_template_program_point')
            ->where('event_template_id', $eventTemplate->id)
            ->get();
        
        if ($pivotRecords->isEmpty()) {
            return 'No program points found for event template';
        }
        
        // Testuj movePoint z pierwszym rekordem
        $firstRecord = $pivotRecords->first();
        $kanban->movePoint($firstRecord->id, 2, [$firstRecord->id]);
        
        return 'Test completed - check logs';
        
    } catch (\Exception $e) {
        Log::error('Test drag & drop error: ' . $e->getMessage());
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/check-data', function () {
    try {
        $eventTemplate = EventTemplate::first();
        if (!$eventTemplate) {
            return response()->json(['error' => 'No event template found']);
        }
        
        $pivotRecords = \Illuminate\Support\Facades\DB::table('event_template_event_template_program_point')
            ->where('event_template_id', $eventTemplate->id)
            ->get();
        
        $programPoints = $eventTemplate->programPoints()->withPivot(['day', 'order_number'])->get();
        
        $data = $programPoints->map(function($point) {
            return [
                'id' => $point->id,
                'pivot_id' => $point->pivot->id,
                'name' => $point->name,
                'day' => $point->pivot->day,
                'order_number' => $point->pivot->order_number
            ];
        });
        
        return response()->json([
            'event_template' => $eventTemplate->name,
            'program_points' => $data,
            'pivot_records_count' => $pivotRecords->count()
        ]);
        
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
});

Route::get('/auto-login', function () {
    try {
        // Sprawdź czy użytkownik testowy istnieje
        $user = \App\Models\User::where('email', 'admin@test.com')->first();
        if (!$user) {
            return 'User not found. Please run: php artisan make:test-user';
        }
        
        // Zaloguj użytkownika
        Auth::login($user, true);
        
        // Przekieruj do panelu admina
        return redirect('/admin');
        
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

// Admin notifications API endpoint
Route::middleware(['auth', 'web'])->prefix('admin')->group(function () {
    Route::get('/notifications/counts', [NotificationController::class, 'getCounts'])->name('admin.notifications.counts');
});

Route::get('/admin/conversations', function () {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login');
    }
    // Najpierw nieprzeczytana, potem najnowsza
    $conversation = Conversation::whereHas('participants', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
        ->with(['participants', 'messages'])
        ->get()
        ->sortByDesc(fn($c) => $c->unreadCount($user))
        ->sortByDesc('last_message_at')
        ->first();
    if ($conversation) {
        return redirect('/admin/chat?conversation=' . $conversation->id);
    }
    return redirect('/admin/chat');
});

// Event price description routes
Route::get('/event/{eventId}/price-description', [EventPriceDescriptionController::class, 'show'])->name('event.price-description.show');
Route::get('/event/{eventId}/price-description/edit', [EventPriceDescriptionController::class, 'edit'])->name('event.price-description.edit');
Route::post('/event/{eventId}/price-description/update', [EventPriceDescriptionController::class, 'update'])->name('event.price-description.update');
