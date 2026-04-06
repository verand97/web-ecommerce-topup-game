<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Transaction;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentService
{
    public function __construct()
    {
        Config::$serverKey       = config('services.midtrans.server_key');
        Config::$clientKey       = config('services.midtrans.client_key');
        Config::$isProduction    = config('services.midtrans.is_production', false);
        Config::$isSanitized     = config('services.midtrans.is_sanitized', true);
        Config::$is3ds           = config('services.midtrans.is_3ds', true);
    }

    /**
     * Create Snap payment token for an order.
     */
    public function createSnapToken(Order $order): string
    {
        $product  = $order->product;
        $customer = $order->user;

        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_number,
                'gross_amount' => (int) $order->total_price,
            ],
            'item_details' => [
                [
                    'id'       => $product->id,
                    'price'    => (int) $product->price,
                    'quantity' => 1,
                    'name'     => $product->name . ' (' . $product->category->name . ')',
                ],
            ],
            'customer_details' => [
                'first_name' => $customer ? $customer->name : 'Guest',
                'email'      => $order->customer_email ?? ($customer?->email ?? 'guest@verandstore.id'),
                'phone'      => $order->customer_phone ?? ($customer?->phone ?? '-'),
            ],
            'callbacks' => [
                'finish' => route('order.status', $order->order_number),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        // Store snap token in transaction record
        Transaction::updateOrCreate(
            ['order_id' => $order->id],
            [
                'snap_token' => $snapToken,
                'amount'     => $order->total_price,
                'status'     => 'pending',
            ]
        );

        return $snapToken;
    }

    /**
     * Process Midtrans webhook notification.
     * Returns the verified notification object or null on verification failure.
     */
    public function processNotification(): ?object
    {
        $notification = new Notification();

        $signatureKey = hash(
            'sha512',
            $notification->order_id .
            $notification->status_code .
            $notification->gross_amount .
            Config::$serverKey
        );

        if ($signatureKey !== $notification->signature_key) {
            return null;
        }

        return $notification;
    }

    public function getClientKey(): string
    {
        return config('services.midtrans.client_key');
    }
}
