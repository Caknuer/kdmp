@extends('layouts.public')

@section('content')
<section class="page-hero page-hero--info">
    <div class="page-hero-inner">
        <span class="hero-pill">Pendaftaran</span>
        <h1>Pendaftaran Anggota KDMP</h1>
        <p>Daftar sebagai anggota KDMP dengan mudah. Pilih tipe keanggotaan yang sesuai dengan kebutuhan Anda.</p>
    </div>
</section>

<section class="container">
    <div class="simple-register">

        <h1>Pendaftaran Anggota</h1>

        {{-- Success message --}}
        @if (session('success'))
            <div class="alert success">
                ✓ {{ session('success') }}
            </div>
        @endif

        {{-- Show code after register --}}
        @if (session('code'))
            <div class="alert success">
                <b>Selamat!</b> Pendaftaran berhasil. <br>
                <small style="display: block; margin-top: 8px;">Kode Anggota: <strong>{{ session('code') }}</strong></small>
                <small style="display: block; margin-top: 8px;">Silakan <a href="{{ route('login') }}" style="color: #007bff; text-decoration: underline;">login di sini</a> menggunakan email dan password Anda.</small>
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

    <form action="{{ route('member.register.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <div class="field">
            <label for="name">Nama Lengkap</label>
            <input id="name" type="text"
                   name="name"
                   placeholder="Nama Lengkap"
                   value="{{ old('name') }}"
                   required>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="field">
            <label for="email">Email</label>
            <input id="email" type="email"
                   name="email"
                   placeholder="Email"
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
                   placeholder="Password (Minimal 8 karakter)"
                   required>
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
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

        <div class="field">
            <label for="role">Tipe Keanggotaan</label>
            <select id="role" name="role" required>
                <option value="">Pilih Tipe Keanggotaan</option>
                <option value="platinum" {{ old('role') === 'platinum' ? 'selected' : '' }}>
                    🏆 Platinum - Khusus untuk Menabung
                </option>
                <option value="premium" {{ old('role') === 'premium' ? 'selected' : '' }}>
                    💎 Premium - Anggota Resmi dengan Hak Penuh
                </option>
            </select>
            @error('role')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="membership-info">
            <div class="info-box" id="platinum-info" style="display: none;">
                <h4>🏆 Anggota Platinum</h4>
                <ul>
                    <li>✅ Khusus untuk menabung saja</li>
                    <li>✅ Tidak perlu verifikasi dokumen berat</li>
                    <li>✅ Langsung aktif setelah daftar</li>
                    <li>✅ Fokus pada layanan simpan pinjam</li>
                </ul>
            </div>

            <div class="info-box" id="premium-info" style="display: none;">
                <h4>💎 Anggota Premium</h4>
                <ul>
                    <li>✅ Anggota resmi dengan hak penuh</li>
                    <li>✅ Perlu melengkapi dokumen (KTP, foto 3x4)</li>
                    <li>✅ Verifikasi oleh admin</li>
                    <li>✅ Hak suara dalam rapat</li>
                    <li>✅ Bonus dan dividen</li>
                </ul>
            </div>
        </div>

        <button type="submit">Daftar Sekarang</button>
    </form>

    </div>
</section>

<style>
.membership-info {
    margin: 20px 0;
}

.info-box {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px;
    margin: 10px 0;
}

.info-box h4 {
    margin: 0 0 10px 0;
    color: #495057;
}

.info-box ul {
    margin: 0;
    padding-left: 20px;
}

.info-box li {
    margin: 5px 0;
    color: #6c757d;
}
</style>

<script>
document.getElementById('role').addEventListener('change', function() {
    const platinumInfo = document.getElementById('platinum-info');
    const premiumInfo = document.getElementById('premium-info');

    if (this.value === 'platinum') {
        platinumInfo.style.display = 'block';
        premiumInfo.style.display = 'none';
    } else if (this.value === 'premium') {
        platinumInfo.style.display = 'none';
        premiumInfo.style.display = 'block';
    } else {
        platinumInfo.style.display = 'none';
        premiumInfo.style.display = 'none';
    }
});
</script>
@endsection
