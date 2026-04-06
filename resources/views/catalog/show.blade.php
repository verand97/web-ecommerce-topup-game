@extends('layouts.app')
@section('title', $category->name . ' — Top Up')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500 mb-8 flex items-center gap-2">
        <a href="{{ route('catalog.index') }}" class="hover:text-white transition-colors">Game</a>
        <span>/</span>
        <span class="text-white">{{ $category->name }}</span>
    </nav>

    {{-- Category Header --}}
    <div class="glass-card p-8 mb-10 flex flex-col sm:flex-row items-start sm:items-center gap-6">
        <div class="glass-card p-6 relative overflow-hidden bg-linear-to-br from-indigo-900/20 to-purple-900/10 border-indigo-500/20 md:sticky md:top-24 max-h-fit">
            @php $emojis = ['mobile-legends'=>'💎','free-fire'=>'🔥','pubg-mobile'=>'🎯','genshin-impact'=>'✨','valorant'=>'⚡']; @endphp
            {{ $emojis[$category->slug] ?? '🎮' }}
        </div>
        <div>
            <h1 class="text-2xl font-bold text-white mb-1">Top Up {{ $category->name }}</h1>
            <p class="text-gray-400 text-sm">{{ $category->description }}</p>
            @if($category->publisher)
                <span class="mt-2 inline-block text-xs text-indigo-300 bg-indigo-500/10 px-3 py-1 rounded-full">{{ $category->publisher }}</span>
            @endif
        </div>
    </div>

    {{-- Product Type Tabs --}}
    @foreach($grouped as $type => $typeProducts)
    <div class="mb-10">
        <h2 class="text-lg font-bold text-white mb-5 flex items-center gap-2">
            @php $typeLabels = ['diamond'=>'💎 Diamond','skin'=>'🎨 Skin','voucher'=>'🎫 Voucher','weekly_pass'=>'📅 Weekly Pass','monthly_pass'=>'📆 Monthly Pass']; @endphp
            {{ $typeLabels[$type] ?? ucfirst($type) }}
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
            @foreach($typeProducts as $product)
            <a href="{{ route('order.create', $product['slug']) }}" class="product-card group p-4">
                <div class="flex items-start justify-between mb-3">
                    <div class="text-2xl">💎</div>
                    @if($product['discount_percent'] > 0)
                        <span class="text-[10px] font-bold bg-red-500/20 text-red-400 px-1.5 py-0.5 rounded-full">-{{ $product['discount_percent'] }}%</span>
                    @endif
                </div>
                <h3 class="font-semibold text-white text-sm mb-1 group-hover:text-indigo-300 transition-colors">{{ $product['name'] }}</h3>
                <p class="text-xs text-gray-500 mb-3">{{ $product['amount'] }} {{ $product['unit'] }}</p>
                <div>
                    @if($product['original_price'] && $product['original_price'] > $product['price'])
                        <p class="text-xs text-gray-500 line-through">Rp {{ number_format((float)$product['original_price'], 0, ',', '.') }}</p>
                    @endif
                    <p class="font-bold text-indigo-400 text-sm">Rp {{ number_format((float)$product['price'], 0, ',', '.') }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endforeach

</div>
@endsection
