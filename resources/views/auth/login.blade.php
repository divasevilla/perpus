@extends('layouts.auth')
@section('title', 'Login')
@section('content')

<div class="auth-box">
    <div class="auth-logo">
        <span class="icon">📚</span>
        <h1>Perpustakaan</h1>
        <p>Masuk ke akun kamu</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif
    @if($errors->has('email'))
        <div class="alert alert-error">{{ $errors->first('email') }}</div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                class="form-control"
                value="{{ old('email') }}"
                placeholder="admin@perpus.com"
                autocomplete="email"
                required
            >
        </div>
        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                class="form-control"
                placeholder="••••••••"
                autocomplete="current-password"
                required
            >
        </div>
        <div class="remember-row" style="margin-bottom:16px;">
            <label>
                <input type="checkbox" name="remember"> Ingat saya
            </label>
        </div>
        <button type="submit" class="btn-primary" id="btn-login">Masuk →</button>
    </form>

    <div class="divider">atau</div>

    <div class="auth-footer">
        Belum punya akun?
        <a href="{{ route('register') }}">Daftar sebagai siswa</a>
    </div>
</div>

@endsection
