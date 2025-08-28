<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\EmailVerificationController;

Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);
Route::get('/verify', [EmailVerificationController::class, 'verify']);
Route::get('/subscriptions', [SubscriptionController::class, 'list']);
