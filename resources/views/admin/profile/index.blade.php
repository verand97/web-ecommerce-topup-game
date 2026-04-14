@extends('layouts.admin')
@section('title', 'Profil Saya')
@section('page-title', '👤 Profil Saya')

@section('content')
<div class="max-w-xl">
    <div class="glass-card p-6">
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-6 flex flex-col items-center sm:flex-row sm:items-start gap-6">
                <div class="shrink-0 relative group">
                    <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="w-24 h-24 rounded-2xl object-cover border-2 border-indigo-500/30">
                    <div class="absolute inset-0 bg-black/50 rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer" onclick="document.getElementById('avatar-input').click()">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                </div>
                <div class="flex-1 w-full relative">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Pilih Foto Baru *</label>
                    <input type="file" name="avatar" id="avatar-input" class="vs-input block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-500/10 file:text-indigo-400 hover:file:bg-indigo-500/20" accept="image/*">
                    <p class="text-xs text-gray-500 mt-2">Format yang didukung: JPG, PNG. Maksimal 2MB.</p>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-2">Nama Lengkap *</label>
                <input type="text" name="name" class="vs-input" value="{{ old('name', auth()->user()->name) }}" required>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-2">Email (Tidak bisa diubah)</label>
                <input type="email" class="vs-input opacity-50 cursor-not-allowed" value="{{ auth()->user()->email }}" disabled>
            </div>

            @if($errors->any())
                <div class="mb-5 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                    <ul class="space-y-1">@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <div class="flex items-center gap-4 mt-8">
                <button type="submit" class="btn-primary flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
