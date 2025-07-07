<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\ReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Appointment API Routes
Route::prefix('appointments')->group(function () {
    Route::get('/', [AppointmentController::class, 'index']); // GET /api/appointments
    Route::get('/stats', [AppointmentController::class, 'stats']); // GET /api/appointments/stats
    Route::get('/{id}', [AppointmentController::class, 'show']); // GET /api/appointments/{id}
});

// Report API Routes
Route::prefix('reports')->group(function () {
    Route::get('/', [ReportController::class, 'index']); // GET /api/reports
    Route::get('/stats', [ReportController::class, 'stats']); // GET /api/reports/stats
    Route::get('/{id}', [ReportController::class, 'show']); // GET /api/reports/{id}
});
