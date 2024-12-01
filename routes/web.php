<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCarController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SessionsController;
use App\Http\Controllers\CreateBookingController;
use App\Http\Controllers\DownloadInvoiceController;
use App\Http\Controllers\GetInvoiceController;
use App\Http\Controllers\ShowAvailableCarsController;
use App\Http\Controllers\StartBookingController;
use App\Http\Controllers\StoreBookingController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [ShowAvailableCarsController::class, '__invoke'])
    ->name('cars.index');
Route::prefix('booking')->group(function () {
    Route::post('/start-booking', [StartBookingController::class, '__invoke'])
        ->name('startBooking');
    Route::get('/create-booking', [CreateBookingController::class, '__invoke'])
        ->name('createBooking');
    Route::post('/store-booking', [StoreBookingController::class, '__invoke'])
        ->name('storeBooking');
    Route::get('/get-invoice/{bookingToken}', [GetInvoiceController::class, '__invoke'])
        ->name('getInvoice');
    Route::get('/download-invoice/{bookingToken}', [DownloadInvoiceController::class, '__invoke'])
        ->name('downloadInvoice');
});
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'create'])
    ->name('registerCreate');
    Route::post('register', [RegisterController::class, 'store'])
        ->name('registerStore');
    Route::get('login', [SessionsController::class, 'create'])
        ->name('sessionCreate');
    Route::post('login', [SessionsController::class, 'store'])
        ->name('sessionStore');
});
Route::middleware('admin')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, '__invoke'])->name('adminDashboard');
        Route::get('/create-car', [AdminCarController::class, 'create'])->name('adminCarCreate');
        Route::post('/create-car', [AdminCarController::class, 'store'])->name('adminCarStore');
        Route::get('/edit-car/{car}/', [AdminCarController::class, 'editModal'])->name('adminCarEditModal');
        Route::put('/update-car/{id}', [AdminCarController::class, 'update'])->name('adminCarUpdate');
        Route::delete('/delete-car/{id}', [AdminCarController::class, 'destroy'])->name('adminCarDestroy');
    });
});
