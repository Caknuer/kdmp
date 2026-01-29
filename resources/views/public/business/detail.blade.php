@extends('layouts.public')

@section('P')

@php
    // Pastikan semua variabel aman
    $name  = $unit->name ?? 'Unit Usaha';
    $desc  = $unit->description ?? 'Deskripsi unit usaha belum tersedia.';
    $thumb = $unit->thumbnail ?? null;

    // Helper kategori otomatis
    $guessCategory = function ($name) {
        $n = strtolower($name);

        if (str_contains($n, 'simpan') || str_contains($n, 'pinjam')) return 'Keuangan';
        if (str_contains($n, 'dagang') || str_contains($n, 'toko')) return 'Perdagangan';
        if (str_contains($n, 'produksi')) return 'Produksi';
        if (str_contains($n, 'jasa')) return 'Jasa';

        return 'Unit Usaha';
    };

    $category = $guessCategory($name);

    // Icon otomatis
    $icon = match ($category) {
        'Keuangan' => '💰',
        'Perdagangan' => '🛒',
        'Produksi' => '🏭',
        'Jasa' => '🧰',
        default => '🏢',
    };
@endphp

<!-- HERO -->
<section class="page-hero">
    <div class="page-hero-inner">
        <h1>{{ $name }}</h1>
        <p>{{ $category }}</p>
    </div>
</section>

<!-- DETAIL UNIT -->
<section class="container">
    <div class="detail-wrapper">

        <!-- Thumbnail -->
        <div class="detail-thumb">
            @php
                $thumbPath = $thumb ? ltrim(preg_replace('#^storage/#', '', $thumb), '/') : null;
            @endphp

            @if($thumbPath)
                <img src="{{ Storage::url($thumbPath) }}" alt="{{ $name }}">
            @else
                <div class="icon-placeholder">{{ $icon }}</div>
                <p>(Belum ada thumbnail)</p>
            @endif
        </div>

        <!-- Content -->
        <div class="detail-content">

            <div class="detail-box">
                <h3>Tentang Unit</h3>
                <p>{{ $desc }}</p>
            </div>

            <div class="detail-box">
                <h3>Contoh Layanan</h3>
                <ul>
                    @if ($category === 'Keuangan')
                        <li>Simpanan wajib & sukarela</li>
                        <li>Pinjaman anggota koperasi</li>
                        <li>Rekap tabungan dan angsuran</li>
                    @elseif ($category === 'Perdagangan')
                        <li>Penjualan kebutuhan pokok</li>
                        <li>Pemasaran produk UMKM desa</li>
                        <li>Distribusi barang koperasi</li>
                    @elseif ($category === 'Produksi')
                        <li>Pengolahan hasil tani lokal</li>
                        <li>Produksi barang koperasi</li>
                        <li>Peningkatan nilai tambah produk desa</li>
                    @else
                        <li>Layanan usaha koperasi sesuai kebutuhan anggota</li>
                        <li>Pemberdayaan ekonomi desa</li>
                    @endif
                </ul>
            </div>

            <!-- Back -->
            <a href="{{ route('public.business.index') }}" class="back-link">
                ← Kembali ke Daftar Unit
            </a>

            <!-- Dummy Info -->
            @if (!empty($isDummy))
                <div class="dummy-note">
                    *Ini data dummy sementara karena unit belum diinput di admin.
                </div>
            @endif

        </div>
    </div>
</section>

@endsection
