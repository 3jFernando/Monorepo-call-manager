<?php

use App\Infrastructure\Http\Controllers\{
    IncomingCallWebhookController    
};
use Illuminate\Support\Facades\Route;

Route::post('/webhooks/calls', IncomingCallWebhookController::class);