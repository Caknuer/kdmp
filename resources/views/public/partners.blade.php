@extends('layouts.public')

@section('P')
<section class="page-hero">
    <div class="page-hero-inner">
        <h1>Mitra KDMP</h1>
        <p>Kerja sama strategis dalam mendukung ekonomi desa</p>
    </div>
</section>

<section class="container">
    <div class="mitra-grid">
        @foreach ($partners as $partner)
            @php
                // logo disimpan di storage/app/public/...
                $logoUrl = !empty($partner->logo) ? asset('storage/' . $partner->logo) : null;

                $initials = collect(explode(' ', $partner->name))
                    ->filter()
                    ->take(2)
                    ->map(fn($w) => strtoupper(mb_substr($w, 0, 1)))
                    ->implode('');

                $desc = $partner->description ?? 'Mitra dalam mendukung program dan kegiatan koperasi.';
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
                        <img src="{{ $logoUrl }}" alt="{{ $partner->name }}">
                    @else
                        <span class="mitra-initials">{{ $initials }}</span>
                    @endif
                </div>

                <div class="mitra-meta">
                    <h4>{{ $partner->name }}</h4>
                    <span class="mitra-chip">Mitra</span>
                    <div class="mitra-sub">{{ $website ?: 'Klik untuk lihat detail' }}</div>
                </div>
            </button>
        @endforeach
    </div>
</section>

<!-- MODAL KHUSUS MITRA (ID beda dari pengurus) -->
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
            <p class="mitra-modal-desc" id="mitraModalDesc"></p>
        </div>

        <div class="mitra-modal-actions">
            <a class="mitra-btn mitra-btn-primary" id="mitraModalWebsiteBtn" href="#" target="_blank" rel="noopener" style="display:none;">
                Kunjungi Website
            </a>
        </div>
    </div>
</div>

@endsection
