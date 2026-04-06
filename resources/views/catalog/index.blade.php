@extends('layouts.app')
@section('title', 'Semua Game')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-white mb-2">🎮 Semua Game</h1>
        <p class="text-gray-400">Pilih game untuk memulai top up</p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        @php $emojis = ['mobile-legends'=>'💎','free-fire'=>'🔥','pubg-mobile'=>'🎯','genshin-impact'=>'✨','valorant'=>'⚡']; @endphp
        @foreach($categories as $cat)
        <a href="{{ route('catalog.show', $cat->slug) }}" class="glass-card p-6 flex flex-col items-center gap-4 text-center group">
            <div class="w-16 h-16 rounded-2xl bg-linear-to-br from-indigo-500/20 to-purple-500/20 border border-indigo-500/15 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
                {{ $emojis[$cat->slug] ?? '🎮' }}
            </div>
            <div>
                <h3 class="font-bold text-white text-sm group-hover:text-indigo-300 transition-colors">{{ $cat->name }}</h3>
                <p class="text-xs text-gray-500 mt-0.5">{{ $cat->publisher }}</p>
            </div>
            <span class="text-xs text-indigo-400 flex items-center gap-1">
                Top Up Sekarang
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </span>
        </a>
        @endforeach
    </div>
</div>
@endsection
