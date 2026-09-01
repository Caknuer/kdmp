@extends('layouts.public')

@section('content')
<section class="page-hero page-hero--info">
    <div class="page-hero-inner">
        <span class="hero-pill">Lengkapi Dokumen</span>
        <h1>Lengkapi Data & Dokumen</h1>
        <p>Lengkapi informasi dan dokumen Anda untuk dapat menggunakan semua fitur anggota KDMP.</p>
    </div>
</section>

<section class="container">
    <div class="simple-register">

        <h1>Lengkapi Dokumen Anggota</h1>

        {{-- Info message --}}
        @if (session('info'))
            <div class="alert info">
                ℹ️ {{ session('info') }}
            </div>
        @endif

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

    <div class="member-info-summary">
        <h3>Informasi Akun</h3>
        <div class="info-grid">
            <div><strong>Nama:</strong> {{ $member->name }}</div>
            <div><strong>Email:</strong> {{ $member->email }}</div>
            <div><strong>Kode Anggota:</strong> {{ $member->code }}</div>
            <div><strong>Tipe:</strong>
                @if($member->role === 'platinum')
                    🏆 Platinum
                @else
                    💎 Premium
                @endif
            </div>
        </div>
    </div>

    <form action="{{ route('member.upload.documents.store') }}"
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
            <label for="ktp_photo">Upload Foto KTP</label>
            <input id="ktp_photo" type="file"
                   name="ktp_photo"
                   accept="image/*"
                   required>
            @error('ktp_photo')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <small class="description">Format: JPG, JPEG, PNG. Maksimal 2MB. Pastikan foto jelas dan terbaca.</small>
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
            <small class="description">Format: JPG, JPEG, PNG. Maksimal 2MB. Background merah atau biru.</small>
        </div>

        <button type="submit">Upload Dokumen</button>
    </form>

    </div>
</section>

<style>
.member-info-summary {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 30px;
}

.member-info-summary h3 {
    margin: 0 0 15px 0;
    color: #495057;
    font-size: 1.1em;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 10px;
}

.info-grid > div {
    padding: 8px 0;
    border-bottom: 1px solid #e9ecef;
}

.description {
    display: block;
    margin-top: 5px;
    color: #6c757d;
    font-size: 0.9em;
}
</style>
@endsection