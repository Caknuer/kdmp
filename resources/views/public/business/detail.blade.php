@extends('layouts.public')

@section('P')
@php
    $name  = $unit->name ?? 'Unit Usaha';
    $desc  = $unit->description ?? 'Deskripsi unit usaha belum tersedia.';
    $thumb = $unit->thumbnail ?? null;

    // Fallback kategori jika DB kosong
    $categoryFallback = function (?string $name): string {
        $n = strtolower($name ?? '');
        if (str_contains($n, 'simpan') || str_contains($n, 'pinjam') || str_contains($n, 'keuangan')) return 'Keuangan';
        if (str_contains($n, 'dagang') || str_contains($n, 'toko') || str_contains($n, 'perdagangan') || str_contains($n, 'minimarket')) return 'Perdagangan';
        if (str_contains($n, 'produksi') || str_contains($n, 'olah')) return 'Produksi';
        if (str_contains($n, 'jasa')) return 'Jasa';
        return 'Lainnya';
    };

    // Fallback icon aman deploy (Heroicons)
    $iconFallback = function (string $category): string {
        return match ($category) {
            'Keuangan' => 'heroicon-o-banknotes',
            'Perdagangan' => 'heroicon-o-shopping-cart',
            'Produksi' => 'heroicon-o-cog-6-tooth',
            'Jasa' => 'heroicon-o-briefcase',
            default => 'heroicon-o-building-storefront',
        };
    };

    // Ambil dari DB, jika kosong pakai fallback
    $category = $unit->category ?: $categoryFallback($name);
    $icon     = $unit->icon ?: $iconFallback($category);

    // URL thumbnail public (aman)
    $thumbUrl = !empty($thumb)
        ? Storage::disk('public')->url($thumb)
        : null;

    // Services dari DB: dipisah baris baru
    $servicesRaw = $unit->services ?? null;
    $services = [];

    if (!empty($servicesRaw)) {
        $services = array_values(array_filter(array_map('trim', preg_split("/\r\n|\n|\r/", $servicesRaw))));
    }

    // fallback layanan kalau services kosong
    $defaultServices = match ($category) {
        'Keuangan' => [
            'Simpanan wajib & sukarela',
            'Pinjaman anggota koperasi',
            'Rekap tabungan dan angsuran',
        ],
        'Perdagangan' => [
            'Penjualan kebutuhan pokok',
            'Pemasaran produk UMKM desa',
            'Distribusi barang koperasi',
        ],
        'Produksi' => [
            'Pengolahan hasil tani lokal',
            'Produksi barang koperasi',
            'Peningkatan nilai tambah produk desa',
        ],
        'Jasa' => [
            'Layanan jasa koperasi sesuai kebutuhan anggota',
            'Dukungan usaha & layanan komunitas',
        ],
        default => [
            'Layanan usaha koperasi sesuai kebutuhan anggota',
            'Pemberdayaan ekonomi desa',
        ],
    };
@endphp

<section class="page-hero">
    <div class="page-hero-inner">
        <h1>{{ $name }}</h1>
        <p>{{ $category }}</p>
    </div>
</section>

@if (!empty($isDummy))
    <section class="container">
        <div class="dummy-note bisnis-dummy-note">
            <strong>Data dummy:</strong> halaman ini menampilkan unit usaha contoh karena data riil belum tersedia.
        </div>
    </section>
@endif

<section class="container">
    <div class="detail-wrapper">

        {{-- Thumbnail / Icon --}}
        <div class="detail-thumb">
            @if ($thumbUrl)
                <img src="{{ $thumbUrl }}" alt="{{ $name }}">
            @else
                <div class="icon-placeholder" aria-hidden="true" style="display:grid; place-items:center;">
                    <x-dynamic-component :component="$icon" class="w-16 h-16" />
                </div>
                <p style="margin-top:10px; color:#64748b; text-align:center;">(Belum ada thumbnail)</p>
            @endif
        </div>

        {{-- Content --}}
        <div class="detail-content">

            <div class="detail-box">
                <h3>Tentang Unit</h3>
                <p style="white-space: pre-wrap;">{{ $desc }}</p>
            </div>

            <div class="detail-box">
                <h3>Contoh Layanan</h3>

                @php
                    $finalServices = !empty($services) ? $services : $defaultServices;
                @endphp

                @if (!empty($finalServices))
                    <ul>
                        @foreach ($finalServices as $srv)
                            <li>{{ $srv }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>Layanan belum tersedia.</p>
                @endif
            </div>

            <div class="detail-box">
                <h3>Lokasi</h3>

                @if(!empty($setting->address))
                    <p>{{ $setting->address }}</p>
                @else
                    <p>Alamat belum tersedia.</p>
                @endif

                @if(!empty($setting->gmaps_embed_src))
                    <div class="business-location-map">
                        <iframe
                            src="{{ $setting->gmaps_embed_src }}"
                            width="100%"
                            height="260"
                            style="border:0; border-radius:14px;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                @endif
            </div>

            <a href="{{ route('public.business.index') }}" class="back-link">
                ← Kembali ke Daftar Unit
            </a>

            @if (!empty($isDummy))
                <div class="dummy-note" style="opacity:.7; font-size:14px;">
                    *Ini data dummy sementara karena unit belum diinput di admin.
                </div>
            @endif

        </div>

    </div>
</section>
@endsection
