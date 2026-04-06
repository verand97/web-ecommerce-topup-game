@extends('layouts.app')
@section('title', 'Riwayat Pesanan')
@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-2xl font-bold text-white mb-8">📋 Riwayat Pesanan</h1>

    @if($orders->isEmpty())
        <div class="glass-card p-14 text-center">
            <div class="text-5xl mb-4">📭</div>
            <h2 class="text-white font-semibold mb-2">Belum ada pesanan</h2>
            <p class="text-gray-400 text-sm mb-6">Mulai top up game favoritmu sekarang!</p>
            <a href="{{ route('catalog.index') }}" class="btn-primary">Mulai Top Up</a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
            <div class="glass-card p-5 flex flex-col sm:flex-row sm:items-center gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="font-mono text-xs text-gray-400">{{ $order->order_number }}</span>
                        <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                    </div>
                    <p class="font-semibold text-white">{{ $order->product->name }}</p>
                    <p class="text-sm text-gray-400">{{ $order->product->category->name }} · {{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-indigo-400">Rp {{ number_format((float)$order->total_price, 0, ',', '.') }}</p>
                    <a href="{{ route('order.status', $order->order_number) }}" class="text-xs text-gray-400 hover:text-white transition-colors mt-1 inline-block">Lihat Detail →</a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-8">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
