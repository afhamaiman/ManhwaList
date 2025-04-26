<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManhwaController;

Route::get('/manhwa', [ManhwaController::class, 'index']);
Route::get('/manhwa/{id}', [ManhwaController::class, 'show']); // ➡️ tambah line ni

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
