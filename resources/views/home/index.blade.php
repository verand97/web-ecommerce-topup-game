@extends('layouts.app')

@section('title', 'Verand Store')
@section('meta_description', 'Top up game Mobile Legends, Free Fire, PUBG Mobile, Genshin Impact — Proses instan, harga terjangkau.')

@section('content')

{{-- ─── Hero ─────────────────────────────────────────────────────────────── --}}
<section class="hero-bg relative overflow-hidden min-h-[85vh] flex items-center">
    {{-- Decorative blobs --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-indigo-600/10 blur-3xl"></div>
        <div class="absolute bottom-0 -left-24 w-80 h-80 rounded-full bg-purple-600/10 blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="animate-fade-up">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-500/15 border border-indigo-500/25 text-indigo-300 text-xs font-medium mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span>
                    Proses Instan 24/7
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-tight mb-6" style="font-family: var(--font-display)">
                    Top Up Game<br>
                    <span class="gradient-text">Lebih Mudah.</span>
                </h1>
                <p class="text-lg text-gray-400 leading-relaxed mb-8 max-w-lg">
                    Platform top up game terpercaya Indonesia. Mobile Legends, Free Fire, PUBG Mobile dan banyak lagi dengan harga terbaik dan proses kilat.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('catalog.index') }}" class="btn-primary text-base py-3 px-6">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Mulai Top Up
                    </a>
                    <a href="#features" class="btn-outline text-base py-3 px-6">Selengkapnya</a>
                </div>

                {{-- Trust badges --}}
                <div class="flex flex-wrap items-center gap-6 mt-10">
                    <div class="flex items-center gap-2 text-sm text-gray-400">
                        <svg class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Aman & Terjamin
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-400">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Proses &lt; 5 Menit
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-400">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        50k+ Pelanggan
                    </div>
                </div>
            </div>

            {{-- Right: animated game icon --}}
            <div class="hidden lg:flex justify-center">
                <div class="relative">
                    <div class="w-64 h-64 rounded-3xl bg-linear-to-br from-indigo-600/30 to-purple-700/30 border border-indigo-500/20 flex items-center justify-center animate-float backdrop-blur-sm">
                        <svg class="w-32 h-32 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                        </svg>
                    </div>
                    <div class="absolute -top-4 -right-4 w-16 h-16 rounded-2xl bg-yellow-500/20 border border-yellow-500/30 flex items-center justify-center animate-float" style="animation-delay:.5s">
                        <span class="text-2xl">💎</span>
                    </div>
                    <div class="absolute -bottom-4 -left-4 w-14 h-14 rounded-2xl bg-purple-500/20 border border-purple-500/30 flex items-center justify-center animate-float" style="animation-delay:1s">
                        <span class="text-xl">⚡</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ─── Game Categories ───────────────────────────────────────────────────── --}}
<section class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-white mb-3">🎮 Pilih Game Favoritmu</h2>
        <p class="text-gray-400">Top up dengan mudah untuk game kesayanganmu</p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        @foreach($categories as $cat)
        <a href="{{ route('catalog.show', $cat->slug) }}" class="glass-card p-5 flex flex-col items-center gap-3 text-center group">
            <div class="w-16 h-16 rounded-2xl bg-linear-to-br from-indigo-500/20 to-purple-500/20 border border-indigo-500/15 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform overflow-hidden">
                @if($cat->image)
                    <img src="{{ Storage::url($cat->image) }}" alt="{{ $cat->name }}" class="w-full h-full object-cover">
                @else
                    @php
                        $emojis = ['mobile-legends' => '💎', 'free-fire' => '🔥', 'pubg-mobile' => '🎯', 'genshin-impact' => '✨', 'valorant' => '⚡'];
                    @endphp
                    {{ $emojis[$cat->slug] ?? '🎮' }}
                @endif
            </div>
            <div>
                <p class="font-semibold text-sm text-white group-hover:text-indigo-300 transition-colors">{{ $cat->name }}</p>
                <p class="text-xs text-gray-500 mt-0.5">{{ $cat->publisher }}</p>
            </div>
        </a>
        @endforeach
    </div>
</section>

{{-- ─── Featured Products ─────────────────────────────────────────────────── --}}
@if($featured->isNotEmpty())
<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-10">
        <div>
            <h2 class="text-2xl font-bold text-white">⚡ Produk Unggulan</h2>
            <p class="text-gray-400 mt-1 text-sm">Pilihan terpopuler dari semua game</p>
        </div>
        <a href="{{ route('catalog.index') }}" class="text-indigo-400 hover:text-indigo-300 text-sm flex items-center gap-1 transition-colors">
            Lihat Semua
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($featured as $product)
        <a href="{{ route('order.create', $product->slug) }}" class="product-card group">
            <div class="p-5">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-12 h-12 rounded-xl bg-linear-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-xl shadow-lg shadow-indigo-500/20">💎</div>
                    @if($product->discount_percent > 0)
                        <span class="text-xs font-bold bg-red-500/20 text-red-400 px-2 py-0.5 rounded-full">-{{ $product->discount_percent }}%</span>
                    @endif
                </div>
                <p class="text-xs text-gray-400 mb-1">{{ $product->category->name }}</p>
                <h3 class="font-semibold text-white text-sm mb-3 group-hover:text-indigo-300 transition-colors">{{ $product->name }}</h3>
                <div class="flex items-center justify-between">
                    <div>
                        @if($product->original_price && $product->original_price > $product->price)
                            <p class="text-xs text-gray-500 line-through">Rp {{ number_format((float)$product->original_price, 0, ',', '.') }}</p>
                        @endif
                        <p class="font-bold text-indigo-400 text-sm">{{ $product->formatted_price }}</p>
                    </div>
                    <div class="w-7 h-7 rounded-lg bg-indigo-500/20 group-hover:bg-indigo-500 flex items-center justify-center transition-colors">
                        <svg class="w-3.5 h-3.5 text-indigo-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif

{{-- ─── How it works ──────────────────────────────────────────────────────── --}}
<section id="features" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-14">
        <h2 class="text-3xl font-bold text-white mb-3">Cara Top Up Super Mudah</h2>
        <p class="text-gray-400">Hanya 3 langkah untuk mendapatkan item game impianmu</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach([
            ['01', '🎮', 'Pilih Game & Produk', 'Pilih game dan nominal top up yang kamu inginkan.'],
            ['02', '🔑', 'Masukkan ID Pemain', 'Input User ID dan Zone ID akun game kamu dengan benar.'],
            ['03', '⚡', 'Bayar & Selesai', 'Pilih metode pembayaran dan item langsung masuk ke akunmu!'],
        ] as $step)
        <div class="glass-card p-8 text-center">
            <div class="w-14 h-14 rounded-2xl bg-linear-to-br from-indigo-600/30 to-purple-700/30 border border-indigo-500/20 flex items-center justify-center text-2xl mx-auto mb-4">
                {{ $step[1] }}
            </div>
            <div class="text-xs font-bold text-indigo-400 mb-2 tracking-widest">LANGKAH {{ $step[0] }}</div>
            <h3 class="font-bold text-white mb-2">{{ $step[2] }}</h3>
            <p class="text-gray-400 text-sm">{{ $step[3] }}</p>
        </div>
        @endforeach
    </div>
</section>

@endsection
