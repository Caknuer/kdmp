@extends('layouts.public')

@section('content')
@php
    $name  = $unit->name ?? 'Unit Usaha';
    $desc  = $unit->description ?? 'Deskripsi unit usaha belum tersedia.';
    $thumbUrl = $unit->thumbnail_url ?? (!empty($unit->thumbnail) ? Storage::disk('public')->url($unit->thumbnail) : null);

    $categoryFallback = function (?string $name): string {
        $n = strtolower($name ?? '');
        if (str_contains($n, 'simpan') || str_contains($n, 'pinjam') || str_contains($n, 'keuangan')) return 'Keuangan';
        if (str_contains($n, 'dagang') || str_contains($n, 'toko') || str_contains($n, 'perdagangan') || str_contains($n, 'minimarket')) return 'Perdagangan';
        if (str_contains($n, 'produksi') || str_contains($n, 'olah')) return 'Produksi';
        if (str_contains($n, 'jasa')) return 'Jasa';
        return 'Lainnya';
    };

    $iconFallback = function (string $category): string {
        return match ($category) {
            'Keuangan' => 'money-bill-wave',
            'Perdagangan' => 'store',
            'Produksi' => 'seedling',
            'Jasa' => 'handshake',
            default => 'building',
        };
    };

    $category = $unit->category ?: $categoryFallback($name);
    $iconName = $unit->icon ? str_replace('fa-', '', $unit->icon) : $iconFallback($category);

    // Parsing services dari database (bisa dipisah newline atau koma)
    $servicesRaw = $unit->services ?? null;
    $services = [];

    if (!empty($servicesRaw)) {
        // Cek jika menggunakan baris baru atau koma
        if (str_contains($servicesRaw, "\n") || str_contains($servicesRaw, "\r")) {
            $services = array_values(array_filter(array_map('trim', preg_split("/\r\n|\n|\r/", $servicesRaw))));
        } else {
            $services = array_values(array_filter(array_map('trim', explode(',', $servicesRaw))));
        }
    }

    $defaultServices = match ($category) {
        'Keuangan' => [
            'Simpanan wajib & sukarela',
            'Pinjaman modal usaha anggota',
            'Tabungan dan investasi masa depan',
        ],
        'Perdagangan' => [
            'Penjualan sembako dan kebutuhan pokok',
            'Pemasaran produk UMKM desa',
            'Penyaluran sarana pertanian dan produksi',
        ],
        'Produksi' => [
            'Pengolahan potensi dan hasil bumi desa',
            'Standardisasi dan pengemasan produk',
            'Peningkatan nilai tambah komoditas lokal',
        ],
        'Jasa' => [
            'Layanan jasa dan utilitas desa',
            'Dukungan usaha dan kemitraan masyarakat',
        ],
        default => [
            'Layanan usaha koperasi untuk kesejahteraan anggota',
            'Pemberdayaan ekonomi masyarakat desa',
        ],
    };
@endphp

<section class="page-hero">
    <div class="page-hero-inner">
        <h1>{{ $name }}</h1>
        <p><span class="bisnis-chip" style="color:white; border-color:rgba(255,255,255,0.4); background:rgba(255,255,255,0.15);">{{ $category }}</span></p>
    </div>
</section>

@if (!empty($isDummy))
    <section class="container">
        <div class="dummy-note bisnis-dummy-note">
            <strong>Data contoh aktif:</strong> halaman ini menampilkan unit usaha contoh karena data riil belum tersedia di admin panel.
        </div>
    </section>
@endif

<section class="container">
    <div class="detail-wrapper">

        {{-- Thumbnail / Icon --}}
        <div class="detail-thumb">
            @if ($thumbUrl)
                <img src="{{ $thumbUrl }}" alt="{{ $name }}" style="width:100%; border-radius:16px; object-fit:cover; max-height:360px;"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';">
                <div class="icon-placeholder" aria-hidden="true" style="display:none; place-items:center; color:#0f172a; height:200px; font-size:4rem; background:#f1f5f9; border-radius:16px;">
                    <i class="fas fa-{{ $iconName }}"></i>
                </div>
            @else
                <div class="icon-placeholder" aria-hidden="true" style="display:grid; place-items:center; color:#0f172a; height:200px; font-size:4rem; background:#f1f5f9; border-radius:16px;">
                    <i class="fas fa-{{ $iconName }}"></i>
                </div>
            @endif
        </div>

        {{-- Content --}}
        <div class="detail-content">

            <div class="detail-box">
                <h3>Tentang Unit</h3>
                <div style="color:#334155; line-height:1.7; white-space:pre-line;">
                    {{ $desc }}
                </div>
            </div>

            <div class="detail-box">
                <h3>Layanan & Produk yang Disediakan</h3>

                @php
                    $finalServices = !empty($services) ? $services : $defaultServices;
                @endphp

                @if (!empty($finalServices))
                    <ul class="list-styled" style="margin:0; padding-left:20px; line-height:1.8;">
                        @foreach ($finalServices as $srv)
                            <li>{{ $srv }}</li>
                        @endforeach
                    </ul>
                @else
                    <p style="color:#64748b;">Rincian layanan belum ditambahkan.</p>
                @endif
            </div>

            <div class="detail-box">
                <h3>Lokasi & Operasional</h3>

                @if(!empty($setting->address))
                    <p style="margin-bottom:12px; color:#334155;">
                        <i class="fas fa-map-marker-alt text-danger" style="margin-right:6px;"></i>
                        {{ $setting->address }}
                    </p>
                @else
                    <p style="color:#64748b;">Lokasi kantor pusat KDMP Wonokerto.</p>
                @endif

                @if(!empty($setting->gmaps_embed_src))
                    <div class="business-location-map" style="margin-top:14px;">
                        <iframe
                            src="{{ $setting->gmaps_embed_src }}"
                            width="100%"
                            height="240"
                            style="border:0; border-radius:12px;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                @endif
            </div>

            <div style="margin-top:24px;">
                <a href="{{ route('public.business.index') }}" class="back-link" style="display:inline-flex; align-items:center; gap:8px; font-weight:600; text-decoration:none;">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Unit
                </a>
            </div>

        </div>

    </div>
</section>
@endsection
