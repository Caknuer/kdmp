@extends('layouts.public')

@section('P')

<!-- HERO -->
<section class="page-hero">
    <div class="page-hero-inner">
        <span class="hero-badge">Struktur Pengawas Resmi</span>
        <h1>Pengawas KDMP</h1>
        <p>Pengawas dan penanggung jawab utama Koperasi Desa Merah Putih</p>
    </div>
</section>

<!-- CONTENT -->
<section class="org-section reveal">
    <div class="container">

        <!-- INFO BAR -->
        <div class="org-info">
            <div>
                <strong>KDMP Wonokerto</strong><br>
                <span>Periode Kepengawasan Aktif</span>
            </div>
            <div class="org-info-right">
                <span>Status</span><br>
                <strong>Aktif</strong>
            </div>
        </div>

        <div class="section-head reveal">
            <h2 class="section-title">Struktur Pengawas</h2>
            <p class="section-subtitle">
                Susunan Pengawas yang bertanggung jawab atas pengelolaan organisasi
            </p>
        </div>

        <div class="org-grid">
            @forelse ($pengawas as $item)
                @include('public.partials.org-card', ['item' => $item])
            @empty
                <div class="empty">
                    <strong>Data sedang diproses</strong>
                    <p>
                        Informasi pengawas sedang dalam tahap verifikasi dan akan
                        dipublikasikan setelah ditetapkan secara resmi.
                    </p>
                </div>
            @endforelse
        </div>

    </div>
</section>

<!-- MODAL DETAIL -->
<!-- MODAL DETAIL -->
<div class="modal-overlay" id="orgModal" aria-hidden="true">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modalName">
        <div class="modal-head">
            <div class="modal-head-left">
                <div class="modal-logo" id="modalPhoto"></div>
                <div class="modal-title">
                    <h3 id="modalName">Detail Pengawas</h3>
                    <small id="modalRole"></small>
                </div>
            </div>
            <button class="modal-close" type="button" aria-label="Tutup">&times;</button>
        </div>

        <div class="modal-body">
            <p class="modal-desc" id="modalBio"></p>
        </div>
    </div>
</div>

@endsection