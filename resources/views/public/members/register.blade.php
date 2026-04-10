@extends('layouts.public')

@section('P')
<div class="container form-container">

    <h1>Pendaftaran Anggota</h1>

    {{-- Success message --}}
    @if (session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Show code after register --}}
    @if (session('code'))
        <div class="alert success">
            <b>Kode Anda:</b> {{ session('code') }} <br>
            Simpan kode ini untuk cek saldo.
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

        <div class="form-row">
            <div class="field">
                <input type="text"
                       name="nik"
                       placeholder="NIK (16 digit)"
                       value="{{ old('nik') }}"
                       required>
                @error('nik')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="field">
                <input type="text"
                       name="name"
                       placeholder="Nama Lengkap"
                       value="{{ old('name') }}"
                       required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="field">
                <input type="email"
                       name="email"
                       placeholder="Email"
                       value="{{ old('email') }}"
                       required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="field">
                <input type="text"
                       name="phone"
                       placeholder="No WhatsApp"
                       value="{{ old('phone') }}"
                       required>
                @error('phone')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="field">
                <select name="gender" required>
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
                <select name="position" required>
                    <option value="">Pilih Posisi</option>
                    <option value="pengawas" {{ old('position') === 'pengawas' ? 'selected' : '' }}>Pengawas</option>
                    <option value="pengurus" {{ old('position') === 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                    <option value="anggota" {{ old('position') === 'anggota' ? 'selected' : '' }}>Anggota</option>
                </select>
                @error('position')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="field">
                <select name="role" required>
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
                <input type="text"
                       name="job"
                       placeholder="Pekerjaan"
                       value="{{ old('job') }}"
                       required>
                @error('job')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="field">
            <textarea name="address"
                      placeholder="Alamat Lengkap"
                      required>{{ old('address') }}</textarea>
            @error('address')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-row">
            <div class="field">
                <input type="date"
                       value="{{ now()->format('Y-m-d') }}"
                       readonly>
                <small>Tanggal pendaftaran otomatis terisi.</small>
            </div>

            <div class="field">
                <div class="file-grid">
                    <div>
                        <label>Upload Foto KTP</label>
                        <input type="file"
                               name="ktp_photo"
                               accept="image/*"
                               required>
                        @error('ktp_photo')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div>
                        <label>Upload Foto 3x4</label>
                        <input type="file"
                               name="photo_3x4"
                               accept="image/*"
                               required>
                        @error('photo_3x4')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <button type="submit">Daftar</button>
    </form>

</div>
@endsection
