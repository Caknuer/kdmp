@extends('layouts.public')

@section('content')
<section class="page-hero page-hero--info">
    <div class="page-hero-inner">
        <span class="hero-pill">Reset Password</span>
        <h1>Lupa Password?</h1>
        <p>Masukkan email Anda untuk menerima link reset password.</p>
    </div>
</section>

<section class="container">
    <div class="simple-register" style="max-width: 400px;">
        <h1>Lupa Password</h1>

        {{-- Success message --}}
        @if (session('success'))
            <div class="alert success">
                ✓ {{ session('success') }}
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

        <form action="{{ route('member.send.reset.link') }}" method="POST">
            @csrf

            <div class="field">
                <label for="email">Email Akun</label>
                <input id="email" type="email"
                       name="email"
                       placeholder="Email yang terdaftar"
                       value="{{ old('email') }}"
                       required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit">Kirim Link Reset</button>
        </form>

        <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid #e5e7eb; text-align: center;">
            <p style="margin: 0 0 12px; color: #6b7280;">Ingin kembali ke login?</p>
            <a href="{{ route('login') }}" style="color: #b91c1c; font-weight: 600; text-decoration: none;">
                Login di sini
            </a>
        </div>
    </div>
</section>
@endsection
