<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ReportController;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Report;
use Illuminate\Support\Carbon;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});
Route::get('/doctorslist', function () {
    return view('doctors');
})->name('doctorslist');


Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/dashboard', function () {
     $today = Carbon::today();

    return view('dashboard', [
        'appointmentsToday' => Appointment::whereDate('appointment_date', $today)->count(),
        'totalDoctors' => Doctor::count(),
        'reportsUploadedToday' => Report::whereDate('created_at', $today)->count(),
        'reportsDownloadedToday' => Report::whereDate('downloaded_at', $today)->count(), // Optional
    ]);
})->middleware('auth')->name('dashboard');



// Public appointment view & booking
Route::post('appointments', [AppointmentController::class, 'store'])->name('appointments.store');

// Appointment status check
Route::get('appointments/status', [AppointmentController::class, 'statusForm'])->name('appointments.statusForm');
Route::post('appointments/status', [AppointmentController::class, 'checkStatus'])->name('appointments.checkStatus');

// Admin views and manages appointments
Route::get('appointments/manage', [AppointmentController::class, 'manage'])->middleware('auth')->name('appointments.manage');
Route::patch('appointments/{id}/update-status', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');
Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index');

Route::get('appointment',[AppointmentController::class,'index']);

Route::get('report/download',[ReportController::class,'download']);

Route::middleware(['auth'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::patch('/reports/{report}/downloaded', [ReportController::class, 'markAsDownloaded'])->name('reports.markAsDownloaded');
});


Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
Route::post('/doctors', [DoctorController::class, 'store'])->name('doctors.store');
Route::delete('/doctors/{id}', [DoctorController::class, 'destroy'])->name('doctors.destroy');

Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::put('/doctors/{doctor}/update-available-date', [DoctorController::class, 'updateAvailableDate'])->name('doctors.update-date');