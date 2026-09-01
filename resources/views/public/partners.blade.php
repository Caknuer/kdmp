@extends('layouts.public')

@section('content')
<section class="page-hero">
    <div class="page-hero-inner">
        <h1>Mitra KDMP</h1>
        <p>Kerja sama strategis dalam mendukung kemajuan ekonomi desa Wonokerto</p>
    </div>
</section>

<section class="container">
    <div class="mitra-grid">
        @forelse ($partners as $partner)
            @php
                $logoUrl = $partner->logo_url;

                $initials = collect(explode(' ', $partner->name))
                    ->filter()
                    ->take(2)
                    ->map(fn($w) => strtoupper(mb_substr($w, 0, 1)))
                    ->implode('');

                $desc = $partner->description ?: 'Mitra strategis dalam mendukung program dan kegiatan koperasi desa.';
                $website = $partner->website ?? '';
            @endphp

            <button
                type="button"
                class="mitra-card"
                data-mitra-name="{{ e($partner->name) }}"
                data-mitra-desc="{{ e($desc) }}"
                data-mitra-website="{{ e($website) }}"
                data-mitra-logo="{{ $logoUrl ?: '' }}"
                data-mitra-initials="{{ $initials }}"
            >
                <div class="mitra-logo">
                    @if ($logoUrl)
                        <img src="{{ $logoUrl }}" alt="{{ $partner->name }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-block';">
                        <span class="mitra-initials" style="display:none;">{{ $initials }}</span>
                    @else
                        <span class="mitra-initials">{{ $initials }}</span>
                    @endif
                </div>

                <div class="mitra-meta">
                    <h4>{{ $partner->name }}</h4>
                    <span class="mitra-chip">Mitra Resmi</span>
                    <div class="mitra-sub">{{ $website ? parse_url($website, PHP_URL_HOST) ?? $website : 'Klik untuk rincian' }}</div>
                </div>
            </button>
        @empty
            <div class="info-empty">
                <h3>Belum ada mitra yang terdaftar</h3>
                <p>Silakan cek kembali nanti. Daftar mitra akan muncul di halaman ini setelah ditambahkan oleh admin.</p>
            </div>
        @endforelse
    </div>
</section>

<!-- MODAL KHUSUS MITRA -->
<div class="mitra-modal-overlay" id="mitraModal" aria-hidden="true">
    <div class="mitra-modal" role="dialog" aria-modal="true" aria-labelledby="mitraModalTitle">
        <div class="mitra-modal-head">
            <div class="mitra-modal-head-left">
                <div class="mitra-modal-logo" id="mitraModalLogo"></div>
                <div class="mitra-modal-title">
                    <h3 id="mitraModalTitle">Detail Mitra</h3>
                    <small id="mitraModalWebsiteText"></small>
                </div>
            </div>

            <button class="mitra-modal-close" type="button" aria-label="Tutup">&times;</button>
        </div>

        <div class="mitra-modal-body">
            <p class="mitra-modal-desc" id="mitraModalDesc" style="white-space:pre-line;"></p>
        </div>

        <div class="mitra-modal-actions">
            <a class="mitra-btn mitra-btn-primary" id="mitraModalWebsiteBtn" href="#" target="_blank" rel="noopener" style="display:none;">
                <i class="fas fa-external-link-alt" style="margin-right:6px;"></i> Kunjungi Website Mitra
            </a>
        </div>
    </div>
</div>
@endsection
