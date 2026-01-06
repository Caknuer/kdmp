@extends('layouts.public')

@section('P')

@include('public.partials.hero')

<div class="container">

    <h1 class="page-title">Koperasi Desa Merah Putih</h1>

    <div class="row">

        <!-- Kolom Berita -->
        <section class="container">
            <div class="section-header">
                <h2>Berita Terbaru</h2>
                <a href="/berita">Lihat semua</a>
            </div>

            <div class="empty-state">
                <p>Belum ada berita yang dipublikasikan.</p>
            </div>
        </section>


        <!-- Kolom Transparansi -->
        <div class="card">
            <h2 class="card-title">Transparansi Singkat</h2>

            <p><strong>Total Pemasukan:</strong> Rp {{ number_format($summary['income'] ?? 0) }}</p>
            <p><strong>Total Pengeluaran:</strong> Rp {{ number_format($summary['expense'] ?? 0) }}</p>
        </div>

    </div>
</div>

@endsection
