@extends('layouts.app')
@section('title', 'Daftar Akun')
@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
    <div class="glass-card p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-2xl bg-linear-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-2xl mx-auto mb-4">🚀</div>
            <h1 class="text-2xl font-bold text-white">Buat Akun Baru</h1>
            <p class="text-gray-400 text-sm mt-1">Bergabung dengan Verand Store</p>
        </div>

        @if($errors->any())
        <div class="mb-5 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
            @foreach($errors->all() as $e)<p>• {{ $e }}</p>@endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="vs-input" required placeholder="John Doe">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="vs-input" required placeholder="email@contoh.com">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">No. HP (opsional)</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="vs-input" placeholder="081234567890">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                <input type="password" name="password" class="vs-input" required placeholder="Min 8 karakter">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="vs-input" required placeholder="Ulangi password">
            </div>
            <button type="submit" class="btn-primary w-full justify-center py-3">
                Buat Akun
            </button>
        </form>

        <p class="text-center text-sm text-gray-400 mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 transition-colors font-medium">Masuk di sini</a>
        </p>
    </div>
</div>
@endsection
