@extends('layouts.app')
@section('title', 'Checkout — ' . $product->name)
@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <nav class="text-sm text-gray-500 mb-8 flex items-center gap-2">
        <a href="{{ route('catalog.show', $category->slug) }}" class="hover:text-white transition-colors">{{ $category->name }}</a>
        <span>/</span>
        <span class="text-white">Checkout</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Order Form --}}
        <div class="lg:col-span-2 glass-card p-8">
            <h1 class="text-xl font-bold text-white mb-6">Detail Pemesanan</h1>

            @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/25">
                <ul class="text-sm text-red-400 space-y-1">
                    @foreach($errors->all() as $error)
                        <li class="flex items-center gap-2"><span>•</span> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('order.store', $product->slug) }}" method="POST" id="order-form">
                @csrf

                {{-- Player ID Fields --}}
                <div class="space-y-5 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            {{ $category->user_id_label }}
                            <span class="text-red-400">*</span>
                        </label>
                        <input
                            type="text"
                            name="player_user_id"
                            value="{{ old('player_user_id') }}"
                            placeholder="Masukkan {{ $category->user_id_label }} kamu..."
                            class="vs-input {{ $errors->has('player_user_id') ? 'error' : '' }}"
                            required
                            id="player-user-id"
                        >
                        @error('player_user_id')
                            <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    @if($category->requires_zone_id)
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            {{ $category->zone_id_label }}
                            <span class="text-red-400">*</span>
                        </label>
                        <input
                            type="text"
                            name="player_zone_id"
                            value="{{ old('player_zone_id') }}"
                            placeholder="Masukkan {{ $category->zone_id_label }} kamu..."
                            class="vs-input {{ $errors->has('player_zone_id') ? 'error' : '' }}"
                            required
                            id="player-zone-id"
                        >
                        @error('player_zone_id')
                            <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1.5">Contoh: 12345 (nomor server)</p>
                    </div>
                    @endif

                    @guest
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Email (opsional)</label>
                        <input type="email" name="customer_email" value="{{ old('customer_email') }}" placeholder="email@contoh.com" class="vs-input">
                        <p class="text-gray-500 text-xs mt-1.5">Untuk konfirmasi pesanan</p>
                    </div>
                    @endguest
                </div>

                {{-- Player IGN Verification Area --}}
                <div id="player-ign-container" class="hidden mb-6 p-4 rounded-xl border">
                    <div class="flex items-center gap-3">
                        <div id="player-ign-icon" class="w-8 h-8 rounded-full flex items-center justify-center shrink-0"></div>
                        <div>
                            <p id="player-ign-text" class="text-sm font-semibold"></p>
                            <p class="text-xs text-gray-500">IGN (In-Game Name) Verifikasi</p>
                        </div>
                    </div>
                </div>

                {{-- How to find ID guide --}}
                <div class="p-4 rounded-xl bg-indigo-500/5 border border-indigo-500/15 mb-6">
                    <p class="text-xs font-semibold text-indigo-300 mb-2">💡 Cara menemukan ID kamu</p>
                    @if($category->slug === 'mobile-legends')
                        <p class="text-xs text-gray-400">Buka Mobile Legends → Tap profil di pojok kiri atas → User ID dan Zone ID terlihat di bawah avatar.</p>
                    @elseif($category->slug === 'free-fire')
                        <p class="text-xs text-gray-400">Buka Free Fire → Tap ikon profil di pojok kiri atas → Lihat Player ID di bawah nama.</p>
                    @else
                        <p class="text-xs text-gray-400">Buka game → Masuk ke menu profil → Cari User ID / Player ID.</p>
                    @endif
                </div>

                <button type="submit" class="btn-primary w-full text-base py-3.5 justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Lanjut ke Pembayaran
                </button>
            </form>
        </div>

        {{-- Order Summary --}}
        <div class="glass-card p-6 h-fit sticky top-24">
            <h2 class="font-bold text-white mb-5 text-sm">Ringkasan Pesanan</h2>
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-indigo-500/20 flex items-center justify-center text-xl">
                    @php $emojis = ['mobile-legends'=>'💎','free-fire'=>'🔥','pubg-mobile'=>'🎯','genshin-impact'=>'✨','valorant'=>'⚡']; @endphp
                    {{ $emojis[$category->slug] ?? '🎮' }}
                </div>
                <div>
                    <p class="font-semibold text-white text-sm">{{ $product->name }}</p>
                    <p class="text-xs text-gray-400">{{ $category->name }}</p>
                </div>
            </div>
            <div class="border-t border-gray-700/50 pt-4 space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Nominal</span>
                    <span class="text-white">{{ $product->amount }} {{ $product->unit }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Harga</span>
                    <span class="text-white font-semibold">{{ $product->formatted_price }}</span>
                </div>
            </div>
            <div class="border-t border-gray-700/50 mt-4 pt-4 flex justify-between">
                <span class="font-bold text-white">Total</span>
                <span class="font-bold text-indigo-400 text-lg">{{ $product->formatted_price }}</span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userIdInput = document.getElementById('player-user-id');
        const zoneIdInput = document.getElementById('player-zone-id');
        const ignContainer = document.getElementById('player-ign-container');
        const ignText = document.getElementById('player-ign-text');
        const ignIcon = document.getElementById('player-ign-icon');
        const submitBtn = document.querySelector('#order-form button[type="submit"]');
        
        let timeout = null;

        function checkPlayer() {
            clearTimeout(timeout);
            const userId = userIdInput.value.trim();
            const zoneId = zoneIdInput ? zoneIdInput.value.trim() : null;
            
            // Basic condition check before calling API
            if (userId.length < 3 || (zoneIdInput && zoneId.length < 1)) {
                ignContainer.classList.add('hidden');
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                return;
            }

            // Show loading state
            ignContainer.classList.remove('hidden', 'bg-red-500/10', 'border-red-500/25', 'bg-green-500/10', 'border-green-500/25');
            ignContainer.classList.add('bg-indigo-500/10', 'border-indigo-500/25');
            ignIcon.className = 'w-8 h-8 rounded-full flex items-center justify-center shrink-0 bg-indigo-500/20 text-indigo-400';
            ignIcon.innerHTML = `<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>`;
            ignText.textContent = "Mengecek ID Game...";
            ignText.className = "text-sm font-semibold text-indigo-300";
            
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');

            timeout = setTimeout(() => {
                const searchParams = new URLSearchParams({
                    action: 'validate_player',
                    category_slug: '{{ $category->slug }}',
                    user_id: userId,
                });
                
                if (zoneId) searchParams.append('zone_id', zoneId);

                fetch(`{{ route('catalog.search') }}?${searchParams.toString()}`)
                    .then(res => res.json())
                    .then(data => {
                        ignContainer.classList.remove('bg-indigo-500/10', 'border-indigo-500/25');
                        if (data.success && data.ign) {
                            ignContainer.classList.add('bg-green-500/10', 'border-green-500/25');
                            ignIcon.className = 'w-8 h-8 rounded-full flex items-center justify-center shrink-0 bg-green-500/20 text-green-400';
                            ignIcon.innerHTML = `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>`;
                            ignText.textContent = data.ign;
                            ignText.className = "text-sm font-semibold text-green-400";
                            submitBtn.disabled = false;
                            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        } else {
                            ignContainer.classList.add('bg-red-500/10', 'border-red-500/25');
                            ignIcon.className = 'w-8 h-8 rounded-full flex items-center justify-center shrink-0 bg-red-500/20 text-red-400';
                            ignIcon.innerHTML = `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>`;
                            ignText.textContent = data.message || "Player tidak ditemukan";
                            ignText.className = "text-sm font-semibold text-red-400";
                        }
                    })
                    .catch(() => {
                        ignContainer.classList.remove('bg-indigo-500/10', 'border-indigo-500/25');
                        ignContainer.classList.add('bg-red-500/10', 'border-red-500/25');
                        ignText.textContent = "Koneksi terputus";
                        ignText.className = "text-sm font-semibold text-red-400";
                    });
            }, 600);
        }

        userIdInput.addEventListener('input', checkPlayer);
        if (zoneIdInput) zoneIdInput.addEventListener('input', checkPlayer);
        
        // Initial state
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
    });
</script>
@endsection
