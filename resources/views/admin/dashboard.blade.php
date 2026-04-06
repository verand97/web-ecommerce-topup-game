@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', '📊 Dashboard')

@section('content')

{{-- ─── Stats ─────────────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
    @php
        $cards = [
            ['label'=>'Revenue Hari Ini', 'value'=>'Rp '.number_format($stats['today_revenue'],0,',','.'), 'icon'=>'💰', 'color'=>'indigo'],
            ['label'=>'Revenue Bulan Ini', 'value'=>'Rp '.number_format($stats['month_revenue'],0,',','.'), 'icon'=>'📈', 'color'=>'purple'],
            ['label'=>'Total Pesanan', 'value'=>number_format($stats['total_orders']), 'icon'=>'📋', 'color'=>'blue'],
            ['label'=>'Menunggu', 'value'=>number_format($stats['pending_orders']), 'icon'=>'⏳', 'color'=>'yellow'],
            ['label'=>'Produk Aktif', 'value'=>number_format($stats['total_products']), 'icon'=>'💎', 'color'=>'green'],
            ['label'=>'Stok Menipis', 'value'=>number_format($stats['low_stock_products']), 'icon'=>'⚠️', 'color'=>'red'],
        ];
    @endphp
    @foreach($cards as $card)
    <div class="glass-card p-5">
        <div class="text-2xl mb-2">{{ $card['icon'] }}</div>
        <p class="text-xs text-gray-400 mb-1">{{ $card['label'] }}</p>
        <p class="text-xl font-bold text-white">{{ $card['value'] }}</p>
    </div>
    @endforeach
</div>

{{-- ─── Revenue Chart ──────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="lg:col-span-2 glass-card p-6">
        <h2 class="font-semibold text-white mb-6">📈 Revenue 7 Hari Terakhir</h2>
        <canvas id="revenue-chart" height="120"
                data-labels="{{ $revenueChart->pluck('label') }}"
                data-revenue="{{ $revenueChart->pluck('revenue') }}">
        </canvas>
    </div>
    <div class="glass-card p-6">
        <h2 class="font-semibold text-white mb-4">🎮 Kategori Game</h2>
        <div class="space-y-3">
            @foreach($categories as $cat)
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-300">{{ $cat->name }}</span>
                <a href="{{ route('admin.products.index', ['category_id' => $cat->id]) }}" class="text-xs text-indigo-400 hover:text-indigo-300 transition-colors">Lihat →</a>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ─── Recent Orders ──────────────────────────────────────────────────────── --}}
<div class="glass-card">
    <div class="flex items-center justify-between p-6 border-b border-gray-700/50">
        <h2 class="font-semibold text-white">📋 Pesanan Terbaru</h2>
        <a href="{{ route('admin.orders.index') }}" class="text-xs text-indigo-400 hover:text-indigo-300 transition-colors">Lihat Semua →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr style="border-bottom:1px solid #1e2a3a">
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400">Order #</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400">Produk</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400">Player ID</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400">Total</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400">Status</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                <tr class="border-b border-gray-800/50 hover:bg-indigo-500/5 transition-colors">
                    <td class="px-6 py-4 font-mono text-xs text-gray-300">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="hover:text-white">{{ $order->order_number }}</a>
                    </td>
                    <td class="px-6 py-4 text-gray-300">{{ $order->product->name }}</td>
                    <td class="px-6 py-4 font-mono text-xs text-gray-400">{{ $order->player_user_id }}</td>
                    <td class="px-6 py-4 text-indigo-400 font-semibold">Rp {{ number_format((float)$order->total_price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4"><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                    <td class="px-6 py-4 text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-10 text-center text-gray-500">Belum ada pesanan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
const canvas = document.getElementById('revenue-chart');
const labels = JSON.parse(canvas.dataset.labels);
const data   = JSON.parse(canvas.dataset.revenue);

new Chart(canvas, {
    type: 'line',
    data: {
        labels,
        datasets: [{
            label: 'Revenue',
            data,
            borderColor: '#6366f1',
            backgroundColor: 'rgba(99,102,241,.12)',
            fill: true,
            tension: .4,
            pointBackgroundColor: '#6366f1',
            pointRadius: 4,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { color: 'rgba(255,255,255,.05)' }, ticks: { color: '#6b7280', font: { size: 11 } } },
            y: { grid: { color: 'rgba(255,255,255,.05)' }, ticks: { color: '#6b7280', font: { size: 11 }, callback: v => 'Rp' + (v/1000).toFixed(0) + 'K' } }
        }
    }
});
</script>
@endpush
