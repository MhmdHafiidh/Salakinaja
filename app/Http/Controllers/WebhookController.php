<?php

namespace App\Http\Controllers;

use App\Services\Payment\MidtransService;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function midtransNotification(Request $request, MidtransService $midtransService)
    {

        return $midtransService->Callback($request);
    }
}
