@extends('layouts.admin')
@section('title', 'Pesanan')
@section('page-title', '📋 Manajemen Pesanan')
@section('content')

<form method="GET" class="glass-card p-5 mb-6 flex flex-wrap gap-3">
    <input type="text" name="order_number" value="{{ request('order_number') }}" placeholder="Cari nomor pesanan..." class="vs-input w-auto flex-1 min-w-48">
    <select name="status" class="vs-input w-auto" onchange="this.form.submit()">
        <option value="">Semua Status</option>
        @foreach(['pending','paid','processing','completed','failed','cancelled','refunded'] as $s)
            <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn-primary text-sm py-2 px-4">Filter</button>
</form>

<div class="glass-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr style="border-bottom:1px solid #1e2a3a">
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400">Order #</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400">Produk</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400">Player ID</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400">Total</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400">Waktu</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="border-b border-gray-800/50 hover:bg-indigo-500/5 transition-colors">
                    <td class="px-5 py-4 font-mono text-xs text-gray-300">{{ $order->order_number }}</td>
                    <td class="px-5 py-4 text-white">{{ $order->product->name }}</td>
                    <td class="px-5 py-4 font-mono text-xs text-gray-400">{{ $order->player_user_id }}{{ $order->player_zone_id ? ' / '.$order->player_zone_id : '' }}</td>
                    <td class="px-5 py-4 text-indigo-400 font-semibold">Rp {{ number_format((float)$order->total_price,0,',','.') }}</td>
                    <td class="px-5 py-4"><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                    <td class="px-5 py-4 text-xs text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</td>
                    <td class="px-5 py-4">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-outline text-xs py-1.5 px-3">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-10 text-center text-gray-500">Belum ada pesanan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-gray-800/50">{{ $orders->links() }}</div>
</div>
@endsection
