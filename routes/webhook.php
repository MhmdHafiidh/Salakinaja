<?php

use App\Http\Controllers\WebhookController;
use App\Services\Payment\MidtransService;
use Illuminate\Support\Facades\Route;

    Route::post('midtrans/notification', [WebhookController::class, 'midtransNotification']);
 ?>
