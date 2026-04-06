@extends('layouts.app')
@section('title', 'Masuk')
@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
    <div class="glass-card p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-2xl bg-linear-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-2xl mx-auto mb-4 animate-glow">⚡</div>
            <h1 class="text-2xl font-bold text-white">Selamat Datang</h1>
            <p class="text-gray-400 text-sm mt-1">Masuk ke akun Verand Store kamu</p>
        </div>

        @if($errors->any())
        <div class="mb-5 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
            @foreach($errors->all() as $e)<p>• {{ $e }}</p>@endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="vs-input" required autofocus placeholder="email@contoh.com">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                <input type="password" name="password" class="vs-input" required placeholder="••••••••">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember" id="remember" class="w-4 h-4 accent-indigo-500">
                <label for="remember" class="text-sm text-gray-400">Ingat saya</label>
            </div>
            <button type="submit" class="btn-primary w-full justify-center py-3">
                Masuk ke Akun
            </button>
        </form>

        <p class="text-center text-sm text-gray-400 mt-6">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300 transition-colors font-medium">Daftar sekarang</a>
        </p>
    </div>
</div>
@endsection
