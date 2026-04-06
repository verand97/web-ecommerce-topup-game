<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\PaymentService;
use App\Services\PlayerValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepo,
        private readonly OrderRepositoryInterface   $orderRepo,
        private readonly PlayerValidationService    $playerValidator,
        private readonly PaymentService             $paymentService,
    ) {}

    public function create(string $productSlug)
    {
        $product  = $this->productRepo->findBySlug($productSlug);
        $category = $product->category;
        return view('order.create', compact('product', 'category'));
    }

    public function store(Request $request, string $productSlug)
    {
        $product  = $this->productRepo->findBySlug($productSlug);
        $category = $product->category;

        $validated = $request->validate([
            'player_user_id'  => 'required|string|max:50',
            'player_zone_id'  => 'nullable|string|max:20',
            'customer_email'  => 'nullable|email|max:100',
            'customer_phone'  => 'nullable|string|max:20',
        ]);

        $result = $this->playerValidator->validate(
            $category,
            $validated['player_user_id'],
            $validated['player_zone_id'] ?? null,
        );

        if (! $result['valid']) {
            return back()->withErrors($result['errors'])->withInput();
        }

        try {
            $order = DB::transaction(function () use ($validated, $product) {
                $stockOk = $this->productRepo->decrementStock($product->id, 1);
                if (! $stockOk) {
                    throw new \RuntimeException('Stok produk habis.');
                }
                $user = Auth::user();
                return $this->orderRepo->create([
                    'order_number'   => Order::generateOrderNumber(),
                    'user_id'        => Auth::id(),
                    'product_id'     => $product->id,
                    'total_price'    => $product->price,
                    'player_user_id' => $validated['player_user_id'],
                    'player_zone_id' => $validated['player_zone_id'] ?? null,
                    'customer_email' => $validated['customer_email'] ?? $user?->email,
                    'customer_phone' => $validated['customer_phone'] ?? $user?->phone,
                    'status'         => Order::STATUS_PENDING,
                ]);
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        try {
            $snapToken = $this->paymentService->createSnapToken($order);
        } catch (\Exception $e) {
            // Delete the pending order if payment gateway fails
            $order->delete();
            return back()->with('error', 'Gagal menghubungkan ke gateway pembayaran (Midtrans). Pastikan API Key valid. Detail: ' . $e->getMessage());
        }

        return redirect()->route('order.payment', $order->order_number)
            ->with('snap_token', $snapToken);
    }

    public function payment(string $orderNumber)
    {
        $order     = $this->orderRepo->findByOrderNumber($orderNumber);
        $snapToken = $order->transaction?->snap_token ?? session('snap_token');
        $clientKey = $this->paymentService->getClientKey();
        return view('order.payment', compact('order', 'snapToken', 'clientKey'));
    }

    public function status(string $orderNumber)
    {
        $order = $this->orderRepo->findByOrderNumber($orderNumber);
        return view('order.status', compact('order'));
    }

    public function history()
    {
        $orders = $this->orderRepo->findByUser((int) Auth::id(), 10);
        return view('order.history', compact('orders'));
    }
}

