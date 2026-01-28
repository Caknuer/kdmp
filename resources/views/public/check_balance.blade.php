@extends('layouts.public')

@section('P')
<div class="container form-container">

    <h1>Cek Saldo Anggota</h1>

    <p style="margin-bottom:20px;">
        Masukkan kode anggota yang Anda terima saat pendaftaran untuk melihat saldo.
    </p>

    {{-- Error --}}
    @if ($errors->any())
        <div class="alert danger">
            <ul style="margin:0; padding-left:18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('member.balance.check') }}" method="POST">
        @csrf

        <div class="field">
            <input type="text"
                   name="code"
                   placeholder="Masukkan Kode (contoh: KDMP-20260128-XXXXXX)"
                   value="{{ old('code') }}"
                   required>
            @error('code')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit">Cek Saldo</button>
    </form>

</div>
@endsection
