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

        {{-- Nama --}}
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

        {{-- NIK --}}
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

        {{-- Alamat --}}
        <div class="field">
            <textarea name="address"
                      placeholder="Alamat Lengkap"
                      required>{{ old('address') }}</textarea>
            @error('address')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Phone --}}
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

        {{-- Upload KTP --}}
        <div class="field">
            <label>Upload Foto KTP</label>
            <input type="file"
                   name="ktp_photo"
                   accept="image/*"
                   required>
            @error('ktp_photo')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit">Daftar</button>
    </form>

</div>
@endsection
