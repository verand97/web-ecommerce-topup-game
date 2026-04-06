<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{
    public function findById(int $id)
    {
        return Order::with(['product.category', 'transaction', 'user'])->findOrFail($id);
    }

    public function findByOrderNumber(string $orderNumber)
    {
        return Order::with(['product.category', 'transaction'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();
    }

    public function findByUser(int $userId, int $perPage = 10)
    {
        return Order::with(['product.category', 'transaction'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function create(array $data)
    {
        return Order::create($data);
    }

    public function updateStatus(int $id, string $status, array $extra = []): bool
    {
        return Order::where('id', $id)->update(array_merge(['status' => $status], $extra)) > 0;
    }

    public function recentOrders(int $limit = 10)
    {
        return Order::with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function todayRevenue(): float
    {
        return (float) Order::whereIn('status', ['completed', 'paid'])
            ->whereDate('created_at', today())
            ->sum('total_price');
    }

    public function monthRevenue(): float
    {
        return (float) Order::whereIn('status', ['completed', 'paid'])
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_price');
    }

    public function paginate(int $perPage = 20, array $filters = [])
    {
        $query = Order::with(['product.category', 'user', 'transaction'])
            ->orderBy('created_at', 'desc');

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (! empty($filters['order_number'])) {
            $query->where('order_number', 'like', '%' . $filters['order_number'] . '%');
        }
        if (! empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (! empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return $query->paginate($perPage);
    }
}
