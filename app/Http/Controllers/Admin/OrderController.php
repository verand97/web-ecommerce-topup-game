<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepo,
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'order_number', 'date_from', 'date_to']);
        $orders  = $this->orderRepo->paginate(20, $filters);
        return view('admin.orders.index', compact('orders', 'filters'));
    }

    public function show(int $id)
    {
        $order = $this->orderRepo->findById($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $request->validate(['status' => 'required|in:pending,paid,processing,completed,failed,cancelled,refunded']);
        $this->orderRepo->updateStatus($id, $request->status);
        return back()->with('success', 'Status pesanan diperbarui.');
    }
}
