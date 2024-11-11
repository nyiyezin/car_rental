<?php

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

Route::get('/', [ShowAvailableCarsController::class, '__invoke'])->name('cars.index');
Route::prefix('booking')->group(function () {
    Route::post('/start-booking', [StartBookingController::class, '__invoke'])->name('startBooking');
    Route::get('/create-booking', [CreateBookingController::class, '__invoke'])->name('createBooking');
    Route::post('/store-booking', [StoreBookingController::class, '__invoke'])->name('storeBooking');
    Route::get('/get-invoice/{bookingToken}', [GetInvoiceController::class, '__invoke'])->name('getInvoice');
    Route::get('/download-invoice/{bookingToken}', [DownloadInvoiceController::class, '__invoke'])->name('downloadInvoice');
});
