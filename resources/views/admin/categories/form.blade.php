@extends('layouts.admin')
@section('title', isset($category) ? 'Edit Kategori' : 'Tambah Kategori')
@section('page-title', isset($category) ? '✏️ Edit Kategori' : '+ Tambah Kategori')
@section('content')
<div class="max-w-2xl">
    <div class="glass-card p-6">
        <form method="POST" action="{{ isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}" enctype="multipart/form-data">
            @csrf
            @isset($category) @method('PUT') @endisset

            @if($errors->any())
            <div class="mb-5 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                <ul class="space-y-1">@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Nama Kategori *</label>
                    <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" class="vs-input" required>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Publisher</label>
                    <input type="text" name="publisher" value="{{ old('publisher', $category->publisher ?? '') }}" class="vs-input">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Deskripsi</label>
                    <textarea name="description" class="vs-input" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
                </div>
                
                <div class="sm:col-span-2 mt-4">
                    <h3 class="text-white font-semibold mb-3">Konfigurasi Form Topup</h3>
                    <div class="p-4 rounded-xl bg-gray-800/50 border border-gray-700">
                        <div class="flex items-center gap-3 mb-4">
                            <input type="checkbox" name="requires_zone_id" value="1" id="requires_zone_id" {{ old('requires_zone_id', $category->requires_zone_id ?? false) ? 'checked' : '' }} class="w-4 h-4 accent-indigo-500">
                            <label for="requires_zone_id" class="text-sm text-gray-300">Memerlukan Zone ID (Misal: Server ID)</label>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Label User ID</label>
                                <input type="text" name="user_id_label" value="{{ old('user_id_label', $category->user_id_label ?? 'User ID') }}" class="vs-input" placeholder="Contoh: User ID / Player ID">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Label Zone ID</label>
                                <input type="text" name="zone_id_label" value="{{ old('zone_id_label', $category->zone_id_label ?? 'Zone ID') }}" class="vs-input" placeholder="Contoh: Zone ID / Server">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Regex User ID (Opsional)</label>
                                <input type="text" name="user_id_regex" value="{{ old('user_id_regex', $category->user_id_regex ?? '') }}" class="vs-input" placeholder="Regex untuk validasi">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Regex Zone ID (Opsional)</label>
                                <input type="text" name="zone_id_regex" value="{{ old('zone_id_regex', $category->zone_id_regex ?? '') }}" class="vs-input" placeholder="Regex untuk validasi">
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Urutan</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="vs-input" min="0">
                </div>
                
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Gambar Icon</label>
                    <input type="file" name="image" class="vs-input" accept="image/*">
                    @isset($category)
                        @if($category->image) <p class="text-xs text-gray-500 mt-1">File saat ini: {{ $category->image }}</p> @endif
                    @endisset
                </div>
                
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Gambar Cover (Banner)</label>
                    <input type="file" name="cover_image" class="vs-input" accept="image/*">
                    @isset($category)
                        @if($category->cover_image) <p class="text-xs text-gray-500 mt-1">File saat ini: {{ $category->cover_image }}</p> @endif
                    @endisset
                </div>

                <div class="flex items-center gap-3 sm:col-span-2">
                    <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }} class="w-4 h-4 accent-indigo-500">
                    <label for="is_active" class="text-sm text-gray-300">Kategori Aktif</label>
                </div>
            </div>

            <div class="flex gap-3 mt-8">
                <button type="submit" class="btn-primary">{{ isset($category) ? 'Simpan Perubahan' : 'Tambah Kategori' }}</button>
                <a href="{{ route('admin.categories.index') }}" class="btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
