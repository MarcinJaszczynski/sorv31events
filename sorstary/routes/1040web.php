<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Support\Facades\Route;

// Dodane dla Spatie Role and 

use Illuminate\Support\Facades\Auth;

use App\Models\TodoStatus;
use Barryvdh\Debugbar\DataCollector\EventCollector;
use EventPayment;
use GuzzleHttp\Psr7\Request;

// Koniec

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('layouts.start');
});


Auth::routes();


// Co



Route::get('/todo/orders', function () {
    return view('todo.orders');
});

Route::get('/todo/indexdone', [TodoController::class, 'indexDone'])->name('todo.indexdone');

// BOOKINGS

Route::get('/bookings/getbookings/{query}', [BookingController::class, 'getBookings']);

// CONTRACTORS

Route::post('/getcontractor', [ContractorController::class, 'getcontractor']);
Route::post('/createElementContractor', [EventContractorController::class, 'createElementContractor']);
Route::post('/eventcontractors/geteventcontractor', [EventContractorController::class, 'geteventcontractor'])->name('eventcontractors.geteventcontractor');
Route::patch('/eventcontractors/updateeventcontractor', [EventContractorController::class, 'updateeventcontractor'])->name('eventcontractors.updateeventcontractor');
Route::get('/contractors/list', [ContractorController::class, 'list']);

// ELEMENTS

Route::post('/eventelements', [EventElementController::class, 'store']);
Route::patch('/eventelements/{id}', [EventElementController::class, 'update']);
Route::delete('/eventelements/{eventelement}', [EventElementController::class, 'destroy']);


// EVENTS
Route::get('/events/list', [EventController::class, 'list']);
Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
Route::get('/events/inquiry', [EventController::class, 'inquiry'])->name('events.inquiry');
Route::get('/events/getevents', [EventController::class, 'getEvents']);
Route::get('/events/getevent/{id}', [EventController::class, 'getEvent']);

//LIVESEARCH

Route::post('/livesearch/contractors', [LiveSearchController::class, 'contractors'])->name('livesearch.contractors');
Route::post('/livesearch/event', [LiveSearchController::class, 'event'])->name('livesearch.event');

// PAYMENTS

Route::post('/eventpayments/addcontractor', [EventPaymentController::class, 'addPaymentContractor']);
Route::post('/eventpayments/getpayment', [EventPaymentController::class, 'getPayment'])->name('getpayment');
Route::get('/eventPayments/index', [EventPaymentController::class, 'index'])->name('eventPaymentsIndex');
Route::post('/eventpayments/storeelementpayment', [EventPaymentController::class, 'storeElementPayment']);
Route::post('eventPayments/store', [EventPaymentController::class, 'store'])->name('eventPaymentStore');
Route::put('eventPayments/update', [EventPaymentController::class, 'update']);
Route::delete('eventPayments/delete/{id}', [EventPaymentController::class, 'destroy']);

//PILOTS

Route::get('/pilots/pilotsquare', [PilotsController::class, 'show'])->name('pilots.pilotsquare');
Route::post('/pilots/geteventpayments', [PilotsController::class, 'getEventPayments'])->name('pilots.geteventpayments');

//REPORTS

Route::get('/reports/entrants', [ReportsController::class, 'entrantsReport']);
Route::get('/reports/accountantpdf', [ReportsController::class, 'accountant'])->name('reports.accountantpdf');



Route::group(['middleware' => ['auth']], function () {
    Route::resource('advance', AdvanceController::class);
    Route::resource('bookings', BookingController::class);
    Route::resource('contractors', ContractorController::class);
    Route::resource('contractorstypes', ContractorTypeController::class);
    Route::resource('currency', CurrencyController::class);
    Route::resource('events', EventController::class);
    Route::resource('eventcontractors', EventContractorController::class);
    // Route::resource('eventelements', EventElementController::class);
    Route::resource('notes', NoteController::class);
    Route::resource('paymenttypes', PaymentTypeController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('todo', TodoController::class);
    Route::resource('todostatus', TodoStatusController::class);
    Route::resource('users', UserController::class);
    Route::resource('notices', NoticeController::class);
});

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('auth');

Route::get('/customersearch', [CustomerSearchController::class, 'index']);
Route::post('/customersearch/search', [CustomerSearchController::class, 'showCustomer'])->name('customersearch.search');

Route::post('/search/latestactivity', [SearchController::class, 'latestActivity']);
Route::post('/search/todosearch', [SearchController::class, 'todoSearch']);




Route::get('/contractors/getall', [ContractorController::class, 'get_all']);


Route::get('/eventinit', [EventinitController::class, 'index'])->name('eventinit');
Route::get('/eventinit/search', [EventinitController::class, 'search'])->name('eventinit.search');
Route::post('/eventinit/store', [EventinitController::class, 'store'])->name('eventinit.store');

// Route::get('/eventelement/all', [EventElementController::class, 'getAllElements']);
// Route::get('/eventelement/{id}', [EventElementController::class, 'getElement']);
// Route::get('/eventelement', [EventElementController::class, 'index']);
// Route::get('/eventelement/{eventelement}/edit', [EventElementController::class, 'edit']);
// Route::get('/eventelement/{eventelement}/edit' . [EventElementController::class, 'edit']);

Route::get('/eventpayments/{id}', [EventPaymentController::class, 'getPayment']);

Route::post('filedelete', [EventController::class, 'fileDelete'])->name('filedelete');

Route::put('eventfileupdate', [EventController::class, 'eventFileUpdate'])->name('eventfileupdate');

Route::delete('/elementDelete/{id}', [EventController::class, 'elementDelete']);


Route::post('/events/fileStore', [EventController::class, 'fileStore'])->name('events.fileStore');

Route::post('eventhotel/store', [EventController::class, 'eventHotelStore']);

Route::put('eventhotel/update', [EventController::class, 'eventHotelUpdate']);

Route::post('/hotels/store', [HotelController::class, 'store'])->name('hotel.store');

Route::delete('/eventHotelDelete', [EventController::class, 'eventHotelDelete'])->name('eventHotelDelete');



// Wydruki

Route::get('/reports/pilotpdf', [PDFController::class, 'generatePilotPDF'])->name('pilotpdf');

Route::get('/reports/hotelpdf', [PDFController::class, 'generateHotelpdf'])->name('hotelpdf');

Route::get('/reports/driverPdf', [PDFController::class, 'generateDriverpdf'])->name('driverpdf');

Route::get('/reports/briefcasePdf', [PDFController::class, 'generateBriefcasepdf'])->name('briefcasepdf');

Route::post('/reports/contractPdf', [PDFController::class, 'generateContractpdf'])->name('contractpdf');



// Płatności





Route::post('notes/createwithrequest/', [NoteController::class, 'add_note_with_request'])->name('notes.createwithrequest');