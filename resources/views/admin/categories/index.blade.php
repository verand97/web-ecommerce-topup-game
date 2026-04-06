@extends('layouts.admin')
@section('title', 'Manajemen Kategori')
@section('page-title', '🎮 Manajemen Kategori')

@section('header-actions')
    <div class="ml-auto">
        <a href="{{ route('admin.categories.create') }}" class="btn-primary text-sm py-2 px-4">+ Tambah Kategori</a>
    </div>
@endsection

@section('content')

{{-- Table --}}
<div class="glass-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr style="border-bottom:1px solid #1e2a3a">
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 w-16">Icon</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400">Nama</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400">Publisher</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr class="border-b border-gray-800/50 hover:bg-indigo-500/5 transition-colors">
                    <td class="px-5 py-4">
                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="w-10 h-10 rounded-lg object-cover bg-gray-800">
                    </td>
                    <td class="px-5 py-4">
                        <p class="font-semibold text-white">{{ $category->name }}</p>
                        <p class="text-xs text-gray-500">{{ $category->slug }}</p>
                    </td>
                    <td class="px-5 py-4 text-gray-300 text-xs">{{ $category->publisher ?? '-' }}</td>
                    <td class="px-5 py-4">
                        <span class="badge {{ $category->is_active ? 'badge-completed' : 'badge-cancelled' }}">
                            {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-5 py-4 flex items-center gap-2">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn-outline text-xs py-1.5 px-3">Edit</a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" onsubmit="return confirm('Hapus kategori ini beserta semua produk di dalamnya?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 hover:text-red-300 px-3 py-1.5 rounded-lg hover:bg-red-500/10 transition-colors border border-red-500/20">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-10 text-center text-gray-500">Belum ada kategori</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-gray-800/50">{{ $categories->links() }}</div>
</div>
@endsection
