<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Verand Store') — Top Up Game #1 Indonesia</title>
    <meta name="description" content="@yield('meta_description', 'Verand Store — Platform top up game terpercaya. Mobile Legends, Free Fire, PUBG Mobile, Genshin Impact dengan harga terbaik dan proses instan.')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

{{-- ─── Navbar ────────────────────────────────────────────────────────────── --}}
<nav class="vs-navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-xl bg-linear-to-br from-indigo-500 to-purple-600 flex items-center justify-center animate-glow">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <span class="font-bold text-lg tracking-wide gradient-text" style="font-family: var(--font-display)">Verand Store</span>
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}" class="text-sm text-gray-300 hover:text-white transition-colors {{ request()->routeIs('home') ? 'text-white' : '' }}">Home</a>
                <a href="{{ route('catalog.index') }}" class="text-sm text-gray-300 hover:text-white transition-colors {{ request()->routeIs('catalog.*') ? 'text-white' : '' }}">Game</a>
                @auth
                    <a href="{{ route('order.history') }}" class="text-sm text-gray-300 hover:text-white transition-colors">Pesanan</a>
                @endauth
            </div>

            {{-- Right side --}}
            <div class="flex items-center gap-3">
                @auth
                    <div class="relative group">
                        <button class="flex items-center gap-2 text-sm text-gray-300 hover:text-white transition-colors">
                            <img src="{{ auth()->user()->avatar_url }}" class="w-8 h-8 rounded-full" alt="avatar">
                            <span class="hidden sm:inline max-w-[100px] truncate">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="absolute right-0 top-full mt-2 w-48 glass-card py-2 hidden group-hover:block">
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-indigo-500/10 transition-colors">
                                    ⚡ Admin Panel
                                </a>
                                <div class="border-t border-gray-700/50 my-1"></div>
                            @endif
                            <a href="{{ route('order.history') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-indigo-500/10 transition-colors">Riwayat Pesanan</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-colors">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn-outline text-sm py-2 px-4">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-primary text-sm py-2 px-4">Daftar</a>
                @endauth

                {{-- Mobile hamburger --}}
                <button id="mobile-menu-btn" class="md:hidden p-2 text-gray-400 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>

        {{-- Mobile Nav --}}
        <div id="mobile-menu" class="hidden md:hidden pb-4 border-t border-gray-800/50 mt-2 pt-4">
            <div class="flex flex-col gap-3">
                <a href="{{ route('home') }}" class="text-sm text-gray-300 hover:text-white">Home</a>
                <a href="{{ route('catalog.index') }}" class="text-sm text-gray-300 hover:text-white">Game</a>
                @auth
                    <a href="{{ route('order.history') }}" class="text-sm text-gray-300 hover:text-white">Pesanan</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-sm text-indigo-400 hover:text-indigo-300">⚡ Admin Panel</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- ─── Flash Messages ─────────────────────────────────────────────────────── --}}
@if(session('success') || session('error'))
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
    @if(session('success'))
        <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-green-500/15 border border-green-500/30 text-green-400 text-sm">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-red-500/15 border border-red-500/30 text-red-400 text-sm">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ session('error') }}
        </div>
    @endif
</div>
@endif

{{-- ─── Page Content ───────────────────────────────────────────────────────── --}}
@yield('content')

{{-- ─── Footer ─────────────────────────────────────────────────────────────── --}}
<footer class="mt-24 border-t border-indigo-500/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-linear-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <span class="font-bold gradient-text" style="font-family: var(--font-display)">Verand Store</span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">Platform top up game terpercaya. Proses instan, harga terbaik, aman dan terjamin.</p>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4 text-sm">Game Populer</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('catalog.show', 'mobile-legends') }}" class="hover:text-white transition-colors">Mobile Legends</a></li>
                    <li><a href="{{ route('catalog.show', 'free-fire') }}" class="hover:text-white transition-colors">Free Fire</a></li>
                    <li><a href="{{ route('catalog.show', 'pubg-mobile') }}" class="hover:text-white transition-colors">PUBG Mobile</a></li>
                    <li><a href="{{ route('catalog.show', 'genshin-impact') }}" class="hover:text-white transition-colors">Genshin Impact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4 text-sm">Bantuan</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-white transition-colors">FAQ</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Hubungi Kami</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a></li>
                </ul>
            </div>
        </div>
        <div class="mt-8 pt-8 border-t border-gray-800/50 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-xs text-gray-500">© {{ date('Y') }} Verand Store. All rights reserved.</p>
            <p class="text-xs text-gray-600">Powered by Laravel 11 · Midtrans</p>
        </div>
    </div>
</footer>

<script>
document.getElementById('mobile-menu-btn').addEventListener('click', () => {
    document.getElementById('mobile-menu').classList.toggle('hidden');
});
</script>

@stack('scripts')
</body>
</html>
