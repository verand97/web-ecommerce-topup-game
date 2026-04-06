@extends('layouts.admin')
@section('title', 'Detail Pesanan')
@section('page-title', '📋 Detail Pesanan')
@section('content')
<div class="max-w-2xl">
    <div class="glass-card p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="font-mono text-sm text-gray-400 mb-1">{{ $order->order_number }}</p>
                <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
            </div>
            <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}" class="flex items-center gap-2">
                @csrf @method('PATCH')
                <select name="status" class="vs-input w-auto text-sm">
                    @foreach(['pending','paid','processing','completed','failed','cancelled','refunded'] as $s)
                        <option value="{{ $s }}" {{ $order->status===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary text-sm py-2 px-4">Update</button>
            </form>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div><p class="text-gray-400 mb-1">Produk</p><p class="text-white font-semibold">{{ $order->product->name }}</p></div>
            <div><p class="text-gray-400 mb-1">Game</p><p class="text-white">{{ $order->product->category->name }}</p></div>
            <div><p class="text-gray-400 mb-1">Player ID</p><p class="text-white font-mono">{{ $order->player_user_id }}</p></div>
            @if($order->player_zone_id)
            <div><p class="text-gray-400 mb-1">Zone ID</p><p class="text-white font-mono">{{ $order->player_zone_id }}</p></div>
            @endif
            <div><p class="text-gray-400 mb-1">Total</p><p class="text-indigo-400 font-bold text-lg">Rp {{ number_format((float)$order->total_price,0,',','.') }}</p></div>
            <div><p class="text-gray-400 mb-1">Dibuat</p><p class="text-white">{{ $order->created_at->format('d M Y H:i') }}</p></div>
        </div>

        @if($order->transaction)
        <div class="mt-6 p-4 rounded-xl bg-indigo-500/5 border border-indigo-500/15">
            <p class="text-xs font-semibold text-indigo-300 mb-2">💳 Informasi Pembayaran</p>
            <div class="grid grid-cols-2 gap-2 text-xs">
                <div><span class="text-gray-400">Metode: </span><span class="text-white">{{ $order->transaction->payment_method ?? '-' }}</span></div>
                <div><span class="text-gray-400">Status: </span><span class="badge badge-{{ $order->transaction->status }}">{{ $order->transaction->status }}</span></div>
                <div><span class="text-gray-400">ID Transaksi: </span><span class="text-white font-mono text-[10px]">{{ $order->transaction->gateway_transaction_id ?? '-' }}</span></div>
            </div>
        </div>
        @endif
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn-outline">← Kembali</a>
</div>
@endsection
