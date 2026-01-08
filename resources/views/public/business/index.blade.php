@extends('layouts.public')

@section('P')
    <!-- HERO -->
<section class="page-hero">
    <div class="page-hero-inner">
        <h1>Unit Bisnis KDMP</h1>
        <p>Unit usaha yang dikelola untuk mendukung ekonomi desa</p>
    </div>
</section>

<!-- GRID UNIT BISNIS -->
<section class="container">
    <div class="row bisnis-grid">

        <div class="bisnis-card"
             data-name="Unit Simpan Pinjam"
             data-category="Keuangan"
             data-desc="Melayani simpan pinjam anggota dengan prinsip koperasi."
             data-icon="💰">
            <div class="bisnis-icon">💰</div>
            <h4>Unit Simpan Pinjam</h4>
            <span>Keuangan</span>
        </div>

        <div class="bisnis-card"
             data-name="Unit Perdagangan"
             data-category="Perdagangan"
             data-desc="Pengelolaan jual beli produk kebutuhan masyarakat."
             data-icon="🛒">
            <div class="bisnis-icon">🛒</div>
            <h4>Unit Perdagangan</h4>
            <span>Perdagangan</span>
        </div>

        <div class="bisnis-card"
             data-name="Unit Produksi"
             data-category="Produksi"
             data-desc="Pengolahan produk lokal berbasis potensi desa."
             data-icon="🏭">
            <div class="bisnis-icon">🏭</div>
            <h4>Unit Produksi</h4>
            <span>Produksi</span>
        </div>

    </div>
</section>

<!-- MODAL UNIT BISNIS -->
<div class="modal-overlay" id="bisnisModal">
    <div class="modal">
        <button class="close">&times;</button>
        <div class="modal-icon" id="modal-icon"></div>
        <h3 id="modal-name"></h3>
        <small id="modal-category"></small>
        <p id="modal-desc"></p>
    </div>
</div>

@endsection
