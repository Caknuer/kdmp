@extends('layouts.public')

@section('content')
<div class="container form-container">

    <h1>Hasil Cek Saldo</h1>

    <div class="card-result">

        <p><b>Nama:</b> {{ $member->name }}</p>
        <p><b>Kode:</b> {{ $member->code }}</p>
        <p><b>Status:</b>
            <span class="badge {{ $status }}">
                {{ strtoupper($status) }}
            </span>
        </p>

        <hr style="margin:15px 0;">

        {{-- Jika belum approved --}}
        @if ($status !== 'approved')
            <div class="alert warning">
                {{ $message }}
            </div>

            <p style="margin-top:10px;">
                Silakan tunggu admin menyetujui pendaftaran Anda.
            </p>

        {{-- Jika sudah approved --}}
        @else
            <div class="alert success">
                Saldo Anda Saat Ini:
            </div>

            <h2 style="margin-top:15px;">
                Rp {{ number_format($balance, 0, ',', '.') }}
            </h2>
        @endif

    </div>

    <div style="margin-top:25px;">
        <a href="{{ route('member.balance.form') }}" class="btn-secondary">
            Cek Lagi
        </a>

        <a href="/" class="btn-primary">
            Kembali ke Beranda
        </a>
    </div>

</div>
@endsection
