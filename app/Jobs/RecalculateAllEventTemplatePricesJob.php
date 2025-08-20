<?php

namespace App\Jobs;

use App\Models\EventTemplate;
use App\Models\EventTemplatePricePerPerson;
use App\Services\EventTemplatePriceCalculator;
use Filament\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RecalculateAllEventTemplatePricesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function handle(): void
    {
        $calculator = new EventTemplatePriceCalculator();
        $templates = EventTemplate::all();
        $ids = $templates->pluck('id')->toArray();
        Log::debug('[DEBUG] Lista event_template_id do przeliczenia (Job): ' . implode(',', $ids));

        // Usuń duplikaty przed przeliczeniem
        $this->removeDuplicatePrices();

        $totalTemplates = 0;
        $totalPricesCreated = 0;
        $totalPricesAfter = 0;
        $errors = 0;

        // Pobierz liczbę wariantów QTY i miejsc startowych
        $qtyCount = \App\Models\EventTemplateQty::count();
        $placesCount = \App\Models\Place::where('starting_place', true)->count();
        $expectedVariants = $qtyCount * $placesCount;

        foreach ($templates as $template) {
            try {
                $before = EventTemplatePricePerPerson::where('event_template_id', $template->id)->count();
                $calculator->calculateAndSave($template);
                $after = EventTemplatePricePerPerson::where('event_template_id', $template->id)->count();
                $totalTemplates++;
                $totalPricesCreated += max($after - $before, 0);
                $totalPricesAfter += $after;

                // Ostrzeżenie jeśli liczba wariantów jest mniejsza niż oczekiwana
                if ($after < $expectedVariants) {
                    Log::warning("[WARNING] Szablon #{$template->id} przeliczony, ale liczba wariantów cenowych ({$after}) jest mniejsza niż oczekiwana ({$expectedVariants})! Możliwe braki lub błędy w danych.");
                }
            } catch (\Throwable $e) {
                $errors++;
                Log::error('Recalculate job error for template #' . $template->id . ': ' . $e->getMessage());
            }
        }

        // Dedupe at the end just in case
        $this->removeDuplicatePrices();

        // Notify requesting user (to database so it’s visible even if page was closed)
        try {
            $user = \App\Models\User::find($this->userId);
            if ($user) {
                Notification::make()
                    ->title('Przeliczanie cen zakończone')
                    ->body("Szablony: {$totalTemplates}, Nowe rekordy: {$totalPricesCreated}, Razem rekordów po przeliczeniu: {$totalPricesAfter}, Błędów: {$errors}")
                    ->success()
                    ->sendToDatabase($user);

                // Opcjonalnie: e-mail (jeśli user ma e-mail)
                if (!empty($user->email)) {
                    $summary = "Szablony: {$totalTemplates}\nNowe rekordy: {$totalPricesCreated}\nRazem rekordów po przeliczeniu: {$totalPricesAfter}\nBłędów: {$errors}";
                    Mail::raw('Przeliczanie cen zakończone.\n' . $summary, function ($m) use ($user) {
                        $m->to($user->email)->subject('Podsumowanie przeliczania cen');
                    });
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to send completion notification: ' . $e->getMessage());
        }
    }

    private function removeDuplicatePrices(): void
    {
        $duplicateGroups = EventTemplatePricePerPerson::select('event_template_id', 'event_template_qty_id', 'currency_id', 'start_place_id')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('event_template_id', 'event_template_qty_id', 'currency_id', 'start_place_id')
            ->having('count', '>', 1)
            ->get();

        foreach ($duplicateGroups as $group) {
            $records = EventTemplatePricePerPerson::where([
                'event_template_id' => $group->event_template_id,
                'event_template_qty_id' => $group->event_template_qty_id,
                'currency_id' => $group->currency_id,
                'start_place_id' => $group->start_place_id,
            ])->orderByDesc('id')->get();

            for ($i = 1; $i < $records->count(); $i++) {
                $records[$i]->delete();
            }
        }
    }
}
