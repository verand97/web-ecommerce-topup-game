<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct(
        private readonly OrderRepositoryInterface   $orderRepo,
        private readonly ProductRepositoryInterface $productRepo,
        private readonly CategoryRepositoryInterface $categoryRepo,
    ) {}

    public function index()
    {
        $stats = [
            'today_revenue'     => $this->orderRepo->todayRevenue(),
            'month_revenue'     => $this->orderRepo->monthRevenue(),
            'total_orders'      => DB::table('orders')->count(),
            'pending_orders'    => DB::table('orders')->where('status', 'pending')->count(),
            'total_products'    => DB::table('products')->where('is_active', true)->count(),
            'low_stock_products'=> DB::table('products')
                ->where('is_active', true)
                ->where('stock', '>', -1)
                ->where('stock', '<=', 5)
                ->count(),
        ];

        $recentOrders  = $this->orderRepo->recentOrders(10);
        $lowStockItems = $this->productRepo->all(['min_price' => 0]);  // all active, filtered below
        $categories    = $this->categoryRepo->allActive();

        // Revenue by last 7 days for chart
        $revenueChart = collect(range(6, 0))->map(function ($daysAgo) {
            $date = now()->subDays($daysAgo)->toDateString();
            return [
                'date'    => $date,
                'label'   => now()->subDays($daysAgo)->format('d M'),
                'revenue' => (float) DB::table('orders')
                    ->whereIn('status', ['completed', 'paid'])
                    ->whereDate('created_at', $date)
                    ->sum('total_price'),
            ];
        });

        return view('admin.dashboard', compact('stats', 'recentOrders', 'revenueChart', 'categories'));
    }
}
