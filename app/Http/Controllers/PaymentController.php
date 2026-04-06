<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Services\PaymentService;
use App\Services\WebhookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct(
        private readonly PaymentService          $paymentService,
        private readonly WebhookService          $webhookService,
        private readonly OrderRepositoryInterface $orderRepo,
    ) {}

    /**
     * Midtrans Webhook endpoint — must be excluded from CSRF verification.
     */
    public function webhook(Request $request)
    {
        $rawPayload = $request->getContent();

        $notification = $this->paymentService->processNotification();

        if (! $notification) {
            Log::warning('[Webhook] Invalid Midtrans signature from ' . $request->ip());
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $success = $this->webhookService->handle(
            $notification,
            $rawPayload,
            $request->ip()
        );

        return response()->json(['message' => $success ? 'OK' : 'Order not found'], $success ? 200 : 404);
    }
}
