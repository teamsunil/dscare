<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/upload_backup',[ApiController::class, 'uploadBackup']);
Route::get('/website-list', [ApiController::class, 'getWebsiteList']);
Route::put('/website-status/{id}', [ApiController::class, 'updateWebsiteStatus']);
Route::get('/update-status-data', [ApiController::class, 'updateStatusData']);
Route::put('/website-data/{id}', [ApiController::class, 'updateWebsiteData']);