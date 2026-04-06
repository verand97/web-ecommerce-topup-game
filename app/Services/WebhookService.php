<?php

namespace App\Services;

use App\Models\Order;
use App\Models\PaymentLog;
use App\Models\Transaction;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebhookService
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository
    ) {}

    /**
     * Handle a verified Midtrans notification object.
     * Uses a DB transaction for atomicity.
     */
    public function handle(object $notification, string $rawPayload, string $ipAddress): bool
    {
        return DB::transaction(function () use ($notification, $rawPayload, $ipAddress) {
            // 1. Find the order by order_number (Midtrans order_id = our order_number)
            $order = Order::where('order_number', $notification->order_id)
                ->lockForUpdate()
                ->first();

            if (! $order) {
                Log::warning('[Webhook] Order not found: ' . $notification->order_id);
                return false;
            }

            // 2. Log the webhook payload for audit
            PaymentLog::create([
                'order_id'                => $order->id,
                'gateway_transaction_id'  => $notification->transaction_id,
                'event_type'              => 'webhook',
                'payload'                 => json_decode($rawPayload, true),
                'ip_address'              => $ipAddress,
                'is_verified'             => true,
            ]);

            // 3. Map Midtrans transaction_status to our statuses
            $transactionStatus = $notification->transaction_status;
            $fraudStatus       = $notification->fraud_status ?? null;

            [$orderStatus, $txStatus, $paidAt] = $this->resolveStatuses(
                $transactionStatus, $fraudStatus
            );

            // 4. Update transaction record
            Transaction::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'gateway_transaction_id' => $notification->transaction_id,
                    'payment_method'         => $notification->payment_type ?? null,
                    'amount'                 => $notification->gross_amount,
                    'status'                 => $txStatus,
                    'gateway_response'       => json_decode($rawPayload, true),
                    'paid_at'                => $paidAt,
                ]
            );

            // 5. Update order status
            $extra = $paidAt ? ['paid_at' => $paidAt] : [];
            if ($orderStatus === Order::STATUS_COMPLETED) {
                $extra['completed_at'] = now();
            }
            $this->orderRepository->updateStatus($order->id, $orderStatus, $extra);

            Log::info("[Webhook] Order {$order->order_number} → {$orderStatus}");
            return true;
        });
    }

    private function resolveStatuses(string $transactionStatus, ?string $fraudStatus): array
    {
        $paidAt = null;

        if ($transactionStatus === 'capture') {
            if ($fraudStatus === 'accept') {
                $paidAt      = now();
                return [Order::STATUS_PAID, 'success', $paidAt];
            }
            return [Order::STATUS_FAILED, 'failed', null];
        }

        if ($transactionStatus === 'settlement') {
            $paidAt = now();
            return [Order::STATUS_PAID, 'success', $paidAt];
        }

        if (in_array($transactionStatus, ['cancel', 'deny'])) {
            return [Order::STATUS_CANCELLED, 'failed', null];
        }

        if ($transactionStatus === 'expire') {
            return [Order::STATUS_CANCELLED, 'expired', null];
        }

        if ($transactionStatus === 'refund') {
            return [Order::STATUS_REFUNDED, 'refund', null];
        }

        return [Order::STATUS_PENDING, 'pending', null];
    }
}
