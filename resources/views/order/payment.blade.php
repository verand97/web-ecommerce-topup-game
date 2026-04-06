@extends('layouts.app')
@section('title', 'Pembayaran — ' . $order->order_number)
@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="glass-card p-8 text-center">
        <div class="w-16 h-16 rounded-2xl bg-indigo-500/20 border border-indigo-500/25 flex items-center justify-center text-3xl mx-auto mb-6">💳</div>
        <h1 class="text-2xl font-bold text-white mb-2">Selesaikan Pembayaran</h1>
        <p class="text-gray-400 text-sm mb-2">Pesanan: <span class="text-indigo-300 font-mono">{{ $order->order_number }}</span></p>
        <p class="text-gray-400 text-sm mb-8">Total: <span class="text-white font-bold text-xl">Rp {{ number_format((float)$order->total_price, 0, ',', '.') }}</span></p>

        @if($snapToken)
            <button id="pay-btn" onclick="snapPay()" class="btn-primary text-base py-3.5 px-10 justify-center mx-auto animate-glow">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Bayar Sekarang
            </button>
            <p class="text-xs text-gray-500 mt-4">Aman · Terenkripsi · Diproses oleh Midtrans</p>
        @else
            <div class="p-4 rounded-xl bg-yellow-500/10 border border-yellow-500/20 text-yellow-400 text-sm">
                Tidak dapat memuat halaman pembayaran. <a href="{{ route('order.status', $order->order_number) }}" class="underline">Cek status pesanan</a>
            </div>
        @endif

        <div class="mt-8 pt-8 border-t border-gray-700/50 text-left">
            <h3 class="text-sm font-semibold text-white mb-4">Detail Pesanan</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-400">Produk</span>
                    <span class="text-white">{{ $order->product->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Game</span>
                    <span class="text-white">{{ $order->product->category->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Player ID</span>
                    <span class="text-white font-mono">{{ $order->player_user_id }}</span>
                </div>
                @if($order->player_zone_id)
                <div class="flex justify-between">
                    <span class="text-gray-400">Zone ID</span>
                    <span class="text-white font-mono">{{ $order->player_zone_id }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
<script>
function snapPay() {
    const btn = document.getElementById('pay-btn');
    btn.disabled = true;
    btn.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memuat...';

    snap.pay('{{ $snapToken }}', {
        onSuccess: (result) => { window.location.href = "{{ route('order.status', $order->order_number) }}"; },
        onPending: (result) => { window.location.href = "{{ route('order.status', $order->order_number) }}"; },
        onError: (result) => {
            btn.disabled = false;
            btn.innerHTML = '⚠️ Coba Lagi';
            alert('Pembayaran gagal. Silakan coba lagi.');
        },
        onClose: () => {
            btn.disabled = false;
            btn.innerHTML = '💳 Bayar Sekarang';
        }
    });
}
</script>
@endpush
