<?php

use App\Infrastructure\Http\Controllers\{
    GetCallsController,
    GetDashboardDataController,
    IncomingCallWebhookController,
    MarkCallAsSpamController
};
use Illuminate\Support\Facades\Route;

Route::get('/calls', GetCallsController::class);
Route::post('/webhooks/calls', IncomingCallWebhookController::class);
Route::patch('/calls/{callId}/spam', MarkCallAsSpamController::class);
Route::get('/calls/dashboard', GetDashboardDataController::class);