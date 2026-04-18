@extends('layouts.public')

@section('P')
<section class="page-hero page-hero--info">
    <div class="page-hero-inner">
        <span class="hero-pill">Login</span>
        <h1>Login Member KDMP</h1>
        <p>Masuk ke akun Anda untuk mengakses dashboard dan melihat informasi saldo.</p>
    </div>
</section>

<section class="container">
    <div class="simple-register">
        <h1>Login Anggota</h1>

        {{-- Session Messages --}}
        @if (session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert danger">
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('member.login.store') }}" method="POST">
            @csrf

            <div class="field">
                <label for="email">Email</label>
                <input id="email" type="email"
                       name="email"
                       placeholder="Email Anda"
                       value="{{ old('email') }}"
                       required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" type="password"
                       name="password"
                       placeholder="Password"
                       required>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="field" style="margin-bottom: 24px;">
                <label style="display:flex; align-items:center; gap:8px; font-weight:normal;">
                    <input type="checkbox" name="remember" value="1">
                    <span>Ingat saya</span>
                </label>
            </div>

            <button type="submit">Login</button>
        </form>

        <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid #e5e7eb; text-align: center;">
            <p style="margin: 0 0 12px; color: #6b7280;">Belum memiliki akun?</p>
            <a href="{{ route('member.register') }}" style="color: #b91c1c; font-weight: 600; text-decoration: none;">
                Daftar di sini
            </a>
        </div>
    </div>
</section>
@endsection
