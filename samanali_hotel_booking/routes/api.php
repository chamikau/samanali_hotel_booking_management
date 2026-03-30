<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\RoomTypeController;

Route::prefix('v1')->group(function () {
    Route::apiResource('room-types', RoomTypeController::class);
    Route::apiResource('rooms', RoomController::class);
    Route::apiResource('bookings', BookingController::class);
    Route::apiResource('payments', PaymentController::class);

    Route::post('bookings/{id}/check-in', [BookingController::class, 'checkIn']);
    Route::post('bookings/{id}/check-out', [BookingController::class, 'checkOut']);
});
