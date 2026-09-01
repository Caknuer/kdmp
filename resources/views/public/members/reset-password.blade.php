@extends('layouts.public')

@section('content')
<section class="page-hero page-hero--info">
    <div class="page-hero-inner">
        <span class="hero-pill">Reset Password</span>
        <h1>Reset Password</h1>
        <p>Buat password baru untuk akun Anda.</p>
    </div>
</section>

<section class="container">
    <div class="simple-register" style="max-width: 400px;">
        <h1>Reset Password Baru</h1>

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

        <form action="{{ route('member.update.password', ['token' => $token]) }}" method="POST">
            @csrf

            <div class="field">
                <label for="password">Password Baru</label>
                <input id="password" type="password"
                       name="password"
                       placeholder="Password Baru (Minimal 8 karakter)"
                       required>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                <small class="description" style="display: block; margin-top: 4px;">Password harus minimal 8 karakter.</small>
            </div>

            <div class="field">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input id="password_confirmation" type="password"
                       name="password_confirmation"
                       placeholder="Konfirmasi Password"
                       required>
                @error('password_confirmation')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit">Reset Password</button>
        </form>

        <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid #e5e7eb; text-align: center;">
            <p style="margin: 0 0 12px; color: #6b7280;">Ingin kembali ke login?</p>
            <a href="{{ route('login') }}" style="color: #b91c1c; font-weight: 600; text-decoration: none;">
                Login di sini
            </a>
        </div>
    </div>
</section>

<style>
.description {
    color: #6c757d;
    font-size: 0.85em;
}
</style>
@endsection
