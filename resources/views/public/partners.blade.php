@extends('layouts.public')

@section('P')
     <!-- HERO -->
<section class="page-hero">
    <div class="page-hero-inner">
        <h1>Mitra KDMP</h1>
        <p>Kerja sama strategis dalam mendukung ekonomi desa</p>
    </div>
</section>

<!-- GRID MITRA -->
<section class="container">
    <div class="row mitra-grid">

        <div class="mitra-card"
             data-name="BUMDes Wonokerto"
             data-type="BUMDes"
             data-desc="Mitra strategis dalam pengelolaan usaha desa."
             data-logo="BUMDES">
            <div class="mitra-logo">BW</div>
            <h4>BUMDes Wonokerto</h4>
            <span>BUMDes</span>
        </div>

        <div class="mitra-card"
             data-name="UMKM Makmur"
             data-type="UMKM"
             data-desc="Mendukung pengembangan produk lokal desa."
             data-logo="UMKM">
            <div class="mitra-logo">UM</div>
            <h4>UMKM Makmur</h4>
            <span>UMKM</span>
        </div>

        <div class="mitra-card"
             data-name="Koperasi Sejahtera"
             data-type="Koperasi"
             data-desc="Kolaborasi penguatan permodalan usaha anggota."
             data-logo="KS">
            <div class="mitra-logo">KS</div>
            <h4>Koperasi Sejahtera</h4>
            <span>Koperasi</span>
        </div>

    </div>
</section>

<!-- MODAL MITRA -->
<div class="modal-overlay" id="mitraModal">
    <div class="modal">
        <button class="close">&times;</button>
        <div class="modal-logo" id="modal-logo"></div>
        <h3 id="modal-name"></h3>
        <small id="modal-type"></small>
        <p id="modal-desc"></p>
    </div>
</div>

@endsection