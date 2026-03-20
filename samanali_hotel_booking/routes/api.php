<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\RoomTypeController;

Route::prefix('v1')->group(function () {
    Route::apiResource('room-types', RoomTypeController::class);
    Route::apiResource('rooms', RoomController::class);
});
