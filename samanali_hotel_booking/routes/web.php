<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;


Route::resource('rooms', RoomController::class);
Route::resource('bookings', BookingController::class);

Route::post('bookings/{id}/check-in', [BookingController::class, 'checkIn'])->name('bookings.checkin');
Route::post('bookings/{id}/check-out', [BookingController::class, 'checkOut'])->name('bookings.checkout');
Route::post('bookings/{id}/pay', [BookingController::class, 'pay'])->name('bookings.pay');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
