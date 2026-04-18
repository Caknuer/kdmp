@extends('layouts.public')

@section('P')
<section class="page-hero page-hero--info">
    <div class="page-hero-inner">
        <span class="hero-pill">Pendaftaran</span>
        <h1>Pendaftaran Anggota KDMP</h1>
        <p>Lengkapi formulir di bawah untuk menjadi anggota resmi. Pastikan semua data dan dokumen valid agar pendaftaran berjalan lancar.</p>
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
                <b>Selamat!</b> Pendaftaran berhasil. Silakan cek email Anda untuk menerima kredensial login. <br>
                <small style="display: block; margin-top: 8px;">Kode Anggota: <strong>{{ session('code') }}</strong></small>
                @if (session('password'))
                    <small style="display: block; margin-top: 8px;">Password Sementara: <strong>{{ session('password') }}</strong></small>
                    <small style="display: block; margin-top: 4px; color: #666;">Harap ubah password setelah login pertama kali.</small>
                @endif
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
            <label for="nik">NIK</label>
            <input id="nik" type="text"
                   name="nik"
                   placeholder="NIK (16 digit)"
                   value="{{ old('nik') }}"
                   required>
            @error('nik')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

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
            <label for="phone">No WhatsApp</label>
            <input id="phone" type="text"
                   name="phone"
                   placeholder="No WhatsApp"
                   value="{{ old('phone') }}"
                   required>
            @error('phone')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="field">
            <label for="gender">Jenis Kelamin</label>
            <select id="gender" name="gender" required>
                <option value="">Pilih Jenis Kelamin</option>
                <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Laki-laki</option>
                <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Perempuan</option>
                <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Lainnya</option>
            </select>
            @error('gender')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="field">
            <label for="position">Posisi</label>
            <select id="position" name="position" required>
                <option value="">Pilih Posisi</option>
                <option value="pengawas" {{ old('position') === 'pengawas' ? 'selected' : '' }}>Pengawas</option>
                <option value="pengurus" {{ old('position') === 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                <option value="anggota" {{ old('position') === 'anggota' ? 'selected' : '' }}>Anggota</option>
            </select>
            @error('position')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="field">
            <label for="role">Role</label>
            <select id="role" name="role" required>
                <option value="">Pilih Role</option>
                <option value="pengawas" {{ old('role') === 'pengawas' ? 'selected' : '' }}>Pengawas</option>
                <option value="pengurus" {{ old('role') === 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                <option value="anggota" {{ old('role') === 'anggota' ? 'selected' : '' }}>Anggota</option>
            </select>
            @error('role')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="field">
            <label for="job">Pekerjaan</label>
            <input id="job" type="text"
                   name="job"
                   placeholder="Pekerjaan"
                   value="{{ old('job') }}"
                   required>
            @error('job')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="field">
            <label for="address">Alamat Lengkap</label>
            <textarea id="address" name="address"
                      placeholder="Alamat Lengkap"
                      required>{{ old('address') }}</textarea>
            @error('address')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="field">
            <label for="registered_at">Tanggal Pendaftaran</label>
            <input id="registered_at" type="date"
                   value="{{ now()->format('Y-m-d') }}"
                   readonly>
            <small class="description">Tanggal pendaftaran otomatis terisi.</small>
        </div>

        <div class="field">
            <label for="ktp_photo">Upload Foto KTP</label>
            <input id="ktp_photo" type="file"
                   name="ktp_photo"
                   accept="image/*"
                   required>
            @error('ktp_photo')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="field">
            <label for="photo_3x4">Upload Foto 3x4</label>
            <input id="photo_3x4" type="file"
                   name="photo_3x4"
                   accept="image/*"
                   required>
            @error('photo_3x4')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit">Daftar</button>
    </form>

    </div>
</section>
@endsection
