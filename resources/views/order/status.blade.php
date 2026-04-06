@extends('layouts.app')
@section('title', 'Status Pesanan — ' . $order->order_number)
@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="glass-card p-8">
        {{-- Status Icon --}}
        <div class="text-center mb-8">
            @php
                $icon  = match($order->status) { 'completed' => '✅', 'paid', 'processing' => '⚡', 'failed' => '❌', 'cancelled' => '🚫', default => '⏳' };
                $color = match($order->status) { 'completed' => 'text-green-400', 'paid','processing' => 'text-indigo-400', 'failed','cancelled' => 'text-red-400', default => 'text-yellow-400' };
            @endphp
            <div class="text-5xl mb-4">{{ $icon }}</div>
            <h1 class="text-xl font-bold text-white mb-1">
                @php $labels = ['pending'=>'Menunggu Pembayaran','paid'=>'Pembayaran Berhasil','processing'=>'Sedang Diproses','completed'=>'Top Up Berhasil!','failed'=>'Top Up Gagal','cancelled'=>'Pesanan Dibatalkan']; @endphp
                {{ $labels[$order->status] ?? ucfirst($order->status) }}
            </h1>
            <p class="text-sm font-mono text-gray-400">{{ $order->order_number }}</p>
        </div>

        {{-- Status Timeline --}}
        <div class="mb-8">
            @php
                $steps = [
                    ['pending',    '⏳', 'Pesanan Dibuat'],
                    ['paid',       '💳', 'Pembayaran Dikonfirmasi'],
                    ['processing', '⚡', 'Sedang Diproses'],
                    ['completed',  '✅', 'Top Up Berhasil'],
                ];
                $statusOrder = ['pending'=>0,'paid'=>1,'processing'=>2,'completed'=>3,'failed'=>3,'cancelled'=>3];
                $currentStep = $statusOrder[$order->status] ?? 0;
            @endphp
            <div class="flex items-center justify-between relative">
                <div class="absolute left-0 right-0 top-4 h-0.5 bg-gray-700 z-0"></div>
                <div class="absolute left-0 top-4 h-0.5 bg-indigo-500 z-0 transition-all" style="width: <?= ($currentStep / 3) * 100 ?>%;"></div>
                @foreach($steps as $i => [$status, $emoji, $label])
                <div class="flex flex-col items-center z-10 text-center" style="min-width:60px">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm mb-2 {{ $i <= $currentStep ? 'bg-indigo-500 text-white' : 'bg-gray-700 text-gray-500' }}">
                        {{ $emoji }}
                    </div>
                    <p class="text-[10px] text-gray-400 leading-tight max-w-[60px]">{{ $label }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Order Details --}}
        <div class="border-t border-gray-700/50 pt-6 space-y-3 text-sm mb-8">
            <div class="flex justify-between"><span class="text-gray-400">Produk</span><span class="text-white">{{ $order->product->name }}</span></div>
            <div class="flex justify-between"><span class="text-gray-400">Game</span><span class="text-white">{{ $order->product->category->name }}</span></div>
            <div class="flex justify-between"><span class="text-gray-400">Player ID</span><span class="text-white font-mono">{{ $order->player_user_id }}</span></div>
            @if($order->player_zone_id)
            <div class="flex justify-between"><span class="text-gray-400">Zone ID</span><span class="text-white font-mono">{{ $order->player_zone_id }}</span></div>
            @endif
            <div class="flex justify-between"><span class="text-gray-400">Total</span><span class="text-indigo-400 font-bold">Rp {{ number_format((float)$order->total_price, 0, ',', '.') }}</span></div>
        </div>

        <div class="flex gap-3">
            @if($order->status === 'pending')
                <a href="{{ route('order.payment', $order->order_number) }}" class="btn-primary flex-1 justify-center">
                    Bayar Sekarang
                </a>
            @endif
            <a href="{{ route('home') }}" class="btn-outline flex-1 justify-center">Kembali ke Home</a>
        </div>
    </div>
</div>
@endsection
