@extends('layouts.public')

@section('P')
<div class="container form-container">

    <h1>Pendaftaran Anggota</h1>

    @if (session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('member.register.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="text" name="name" placeholder="Nama Lengkap" required>
        <input type="text" name="nik" placeholder="NIK (16 digit)" required>
        <textarea name="address" placeholder="Alamat Lengkap" required></textarea>
        <input type="text" name="phone" placeholder="No WhatsApp" required>

        <label>Upload KTP</label>
        <input type="file" name="ktp_file" accept="image/*" required>

        <button type="submit">Daftar</button>
    </form>

</div>
@endsection
