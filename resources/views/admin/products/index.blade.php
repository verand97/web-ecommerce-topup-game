@extends('layouts.admin')
@section('title', 'Manajemen Produk')
@section('page-title', '💎 Manajemen Produk')

@section('header-actions')
    <div class="ml-auto">
        <a href="{{ route('admin.products.create') }}" class="btn-primary text-sm py-2 px-4">+ Tambah Produk</a>
    </div>
@endsection

@section('content')

{{-- Filters --}}
<div class="glass-card p-5 mb-6 flex flex-wrap gap-4">
    <form method="GET" class="flex flex-wrap gap-3 flex-1">
        <select name="category_id" class="vs-input w-auto" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ (request('category_id') == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <select name="type" class="vs-input w-auto" onchange="this.form.submit()">
            <option value="">Semua Tipe</option>
            @foreach(['diamond','skin','voucher','weekly_pass','monthly_pass'] as $t)
                <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$t)) }}</option>
            @endforeach
        </select>
    </form>
</div>

{{-- Table --}}
<div class="glass-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr style="border-bottom:1px solid #1e2a3a">
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400">Produk</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400">Kategori</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400">Harga</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400">Stok</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr class="border-b border-gray-800/50 hover:bg-indigo-500/5 transition-colors">
                    <td class="px-5 py-4">
                        <p class="font-semibold text-white">{{ $product->name }}</p>
                        <p class="text-xs text-gray-500">{{ $product->amount }} {{ $product->unit }}</p>
                    </td>
                    <td class="px-5 py-4 text-gray-300 text-xs">{{ $product->category->name }}</td>
                    <td class="px-5 py-4 text-indigo-400 font-semibold">{{ $product->formatted_price }}</td>
                    <td class="px-5 py-4">
                        @if($product->stock === -1)
                            <span class="badge badge-completed">∞ Unlimited</span>
                        @elseif($product->stock <= 5)
                            <span class="badge badge-failed">{{ $product->stock }}</span>
                        @else
                            <span class="badge badge-paid">{{ $product->stock }}</span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <span class="badge {{ $product->is_active ? 'badge-completed' : 'badge-cancelled' }}">
                            {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-5 py-4 flex items-center gap-2">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-outline text-xs py-1.5 px-3">Edit</a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" onsubmit="return confirm('Hapus produk ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 hover:text-red-300 px-3 py-1.5 rounded-lg hover:bg-red-500/10 transition-colors border border-red-500/20">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-5 py-10 text-center text-gray-500">Belum ada produk</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-gray-800/50">{{ $products->links() }}</div>
</div>
@endsection
