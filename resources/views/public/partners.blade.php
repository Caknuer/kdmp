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
                $logoUrl = !empty($partner->logo) ? asset('storage/' . $partner->logo) : null;

                $initials = collect(explode(' ', $partner->name))
                    ->filter()
                    ->take(2)
                    ->map(fn($w) => strtoupper(mb_substr($w, 0, 1)))
                    ->implode('');

                $desc = $partner->description ?? 'Mitra dalam mendukung program dan kegiatan koperasi.';
                $website = $partner->website ?? '';
            @endphp

            <div class="mitra-card"
                 role="button"
                 tabindex="0"
                 data-name="{{ $partner->name }}"
                 data-desc="{{ $desc }}"
                 data-website="{{ $website }}"
                 data-logo="{{ $logoUrl ?? $initials }}">
                <div class="mitra-logo">
                    @if ($logoUrl)
                        <img src="{{ $logoUrl }}" alt="{{ $partner->name }}">
                    @else
                        {{ $initials }}
                    @endif
                </div>

                <div class="mitra-meta">
                    <h4>{{ $partner->name }}</h4>
                    <span class="mitra-chip">Mitra</span>
                    <div class="mitra-sub">{{ $website ?: 'Klik untuk lihat detail' }}</div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- JENDELA MENGAMBANG (MODAL) -->
<div class="modal-overlay" id="mitraModal" aria-hidden="true">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modalName">
        <div class="modal-head">
            <div class="modal-head-left">
                <div class="modal-logo" id="modalLogo"></div>
                <div class="modal-title">
                    <h3 id="modalName">Detail Mitra</h3>
                    <small id="modalWebsiteText"></small>
                </div>
            </div>

            <button class="modal-close" type="button" aria-label="Tutup">&times;</button>
        </div>

        <div class="modal-body">
            <p class="modal-desc" id="modalDesc"></p>
        </div>

        <div class="modal-actions">
            <a class="btn btn-primary" id="modalWebsiteBtn" href="#" target="_blank" rel="noopener" style="display:none;">
                Kunjungi Website
            </a>
        </div>
    </div>
</div>

@endsection