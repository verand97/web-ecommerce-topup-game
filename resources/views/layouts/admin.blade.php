<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — @yield('title', 'Dashboard') · Verand Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background:#080b10">

{{-- ─── Sidebar ────────────────────────────────────────────────────────────── --}}
<aside class="admin-sidebar" id="admin-sidebar">
    <div class="p-6">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 mb-8">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="w-8 h-8 object-contain rounded-xl" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=VS&background=6366f1&color=fff&rounded=true';">
            <span class="font-bold gradient-text" style="font-family:var(--font-display)">Verand Store</span>
        </a>

        @php
            $navItems = [
                ['route' => 'admin.dashboard',          'icon' => '📊', 'label' => 'Dashboard'],
                ['route' => 'admin.orders.index',        'icon' => '📋', 'label' => 'Pesanan'],
                ['route' => 'admin.products.index',      'icon' => '💎', 'label' => 'Produk'],
                ['route' => 'admin.categories.index',    'icon' => '🎮', 'label' => 'Kategori'],
            ];
        @endphp

        <nav class="space-y-1">
            @foreach($navItems as $item)
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
                      {{ request()->routeIs($item['route']) ? 'bg-indigo-500/20 text-white border border-indigo-500/25' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
                <span class="text-base">{{ $item['icon'] }}</span>
                {{ $item['label'] }}
            </a>
            @endforeach
        </nav>

        <div class="absolute bottom-6 left-6 right-6">
            <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-800/50 border border-gray-700/50">
                <img src="{{ auth()->user()->avatar_url }}" class="w-8 h-8 rounded-full object-cover" alt="avatar">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-gray-400">Administrator</p>
                </div>
                <a href="{{ route('admin.profile') }}" class="text-gray-400 hover:text-white transition-colors" title="Edit Profil">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </a>
            </div>
            <div class="flex gap-2 mt-2">
                <a href="{{ route('home') }}" class="flex-1 text-center text-xs text-gray-400 hover:text-white py-2 rounded-lg hover:bg-gray-800 transition-colors">← Home</a>
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full text-xs text-red-400 hover:text-red-300 py-2 rounded-lg hover:bg-red-500/10 transition-colors">Logout</button>
                </form>
            </div>
        </div>
    </div>
</aside>

{{-- ─── Main Content ───────────────────────────────────────────────────────── --}}
<div class="admin-main min-h-screen">
    {{-- Topbar --}}
    <header style="background:rgba(8,11,16,.9); border-bottom:1px solid #1e2a3a" class="sticky top-0 z-30 px-6 py-4 flex items-center gap-4">
        <button id="sidebar-toggle" class="lg:hidden text-gray-400 hover:text-white">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <h1 class="text-sm font-semibold text-white">@yield('page-title', 'Dashboard')</h1>
        @yield('header-actions')
    </header>

    {{-- Flash --}}
    @if(session('success') || session('error'))
    <div class="px-6 pt-4">
        @if(session('success'))
        <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-green-500/10 border border-green-500/25 text-green-400 text-sm mb-0">
            ✅ {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/25 text-red-400 text-sm">
            ❌ {{ session('error') }}
        </div>
        @endif
    </div>
    @endif

    <main class="p-6">@yield('content')</main>
</div>

<script>
document.getElementById('sidebar-toggle').addEventListener('click', () => {
    document.getElementById('admin-sidebar').classList.toggle('open');
});
</script>
@stack('scripts')
</body>
</html>
