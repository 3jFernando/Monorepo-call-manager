<?php

use App\Infrastructure\Http\Controllers\{
    IncomingCallWebhookController,
    RecentsCallsController
};
use Illuminate\Support\Facades\Route;

Route::post('/webhooks/calls', IncomingCallWebhookController::class);
Route::get('/recents-calls', RecentsCallsController::class);