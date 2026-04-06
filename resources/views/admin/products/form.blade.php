@extends('layouts.admin')
@section('title', isset($product) ? 'Edit Produk' : 'Tambah Produk')
@section('page-title', isset($product) ? '✏️ Edit Produk' : '+ Tambah Produk')
@section('content')
<div class="max-w-2xl">
    <div class="glass-card p-6">
        <form method="POST" action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            @isset($product) @method('PUT') @endisset

            @if($errors->any())
            <div class="mb-5 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                <ul class="space-y-1">@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Nama Produk *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" class="vs-input" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Kategori *</label>
                    <select name="category_id" class="vs-input" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Tipe *</label>
                    <select name="type" class="vs-input" required>
                        @foreach(['diamond','skin','voucher','weekly_pass','monthly_pass','other'] as $t)
                            <option value="{{ $t }}" {{ old('type', $product->type ?? '') === $t ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$t)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Harga (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}" class="vs-input" required min="0">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Harga Original (Rp)</label>
                    <input type="number" name="original_price" value="{{ old('original_price', $product->original_price ?? '') }}" class="vs-input" min="0">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Jumlah *</label>
                    <input type="number" name="amount" value="{{ old('amount', $product->amount ?? 0) }}" class="vs-input" required min="0">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Satuan *</label>
                    <input type="text" name="unit" value="{{ old('unit', $product->unit ?? 'Diamond') }}" class="vs-input" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Stok (-1 = Unlimited)</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock ?? -1) }}" class="vs-input" required min="-1">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Urutan</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $product->sort_order ?? 0) }}" class="vs-input" min="0">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Gambar Produk</label>
                    <input type="file" name="image" class="vs-input" accept="image/*">
                    @isset($product)
                        @if($product->image) <p class="text-xs text-gray-500 mt-1">File saat ini: {{ $product->image }}</p> @endif
                    @endisset
                </div>
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }} class="w-4 h-4 accent-indigo-500">
                    <label for="is_active" class="text-sm text-gray-300">Aktif</label>
                </div>
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }} class="w-4 h-4 accent-indigo-500">
                    <label for="is_featured" class="text-sm text-gray-300">Featured / Unggulan</label>
                </div>
            </div>

            <div class="flex gap-3 mt-8">
                <button type="submit" class="btn-primary">{{ isset($product) ? 'Simpan Perubahan' : 'Tambah Produk' }}</button>
                <a href="{{ route('admin.products.index') }}" class="btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
