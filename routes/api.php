<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TelegramWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class,'register']);
Route::post('login',    [AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [AuthController::class,'me']);
    Route::post('logout', [AuthController::class,'logout']);

    // Clients
    Route::get('clients', [ClientController::class,'index']);
    Route::post('clients', [ClientController::class,'store']);
    Route::get('clients/{client}', [ClientController::class,'show']);
    Route::put('clients/{client}', [ClientController::class,'update']);
    Route::get('clients/{client}/link', [ClientController::class,'linkToken']); // unique /start link

    // Invoices
    Route::get('invoices', [InvoiceController::class,'index']);
    Route::post('invoices', [InvoiceController::class,'store']);
    Route::get('invoices/{invoice}', [InvoiceController::class,'show']);
    Route::put('invoices/{invoice}', [InvoiceController::class,'update']);
    Route::patch('invoices/{invoice}/status', [InvoiceController::class,'setStatus']);
});

// Telegram webhook (public)
Route::post('telegram/webhook', TelegramWebhookController::class);
