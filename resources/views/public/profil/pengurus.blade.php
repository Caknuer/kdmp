@extends('layouts.public')

@section('P')

<!-- HERO -->
<section class="page-hero">
    <div class="page-hero-inner">
        <h1>Pengurus KDMP</h1>
        <p>Struktur pengelola Koperasi Desa Merah Putih</p>
    </div>
</section>

<!-- HALL PENGURUS -->
<section class="container">
    <div class="row pengurus-grid">

        <div class="pengurus-card"
             data-name="Budi Santoso"
             data-role="Ketua"
             data-desc="Bertanggung jawab atas arah dan kebijakan koperasi.">
            <div class="avatar">BS</div>
            <h4>Budi Santoso</h4>
            <span>Ketua</span>
        </div>

        <div class="pengurus-card"
             data-name="Siti Aminah"
             data-role="Sekretaris"
             data-desc="Mengelola administrasi dan dokumentasi koperasi.">
            <div class="avatar">SA</div>
            <h4>Siti Aminah</h4>
            <span>Sekretaris</span>
        </div>

        <div class="pengurus-card"
             data-name="Ahmad Fauzi"
             data-role="Bendahara"
             data-desc="Mengelola keuangan koperasi secara transparan.">
            <div class="avatar">AF</div>
            <h4>Ahmad Fauzi</h4>
            <span>Bendahara</span>
        </div>

    </div>
</section>

<!-- MODAL -->
<div class="modal-overlay" id="modal">
    <div class="modal">
        <button class="close">&times;</button>
        <h3 id="modal-name"></h3>
        <small id="modal-role"></small>
        <p id="modal-desc"></p>
    </div>
</div>

@endsection