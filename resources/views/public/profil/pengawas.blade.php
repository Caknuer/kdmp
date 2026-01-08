@extends('layouts.public')

@section('P')
   <!-- HERO -->
<section class="page-hero">
    <div class="page-hero-inner">
        <h1>Dewan Pengawas KDMP</h1>
        <p>Pengawasan dan pengendalian kinerja koperasi</p>
    </div>
</section>

<!-- HALL PENGAWAS -->
<section class="container">
    <div class="row pengawas-grid">

        <div class="pengawas-card"
             data-name="H. Slamet Riyadi"
             data-role="Ketua Pengawas"
             data-desc="Mengawasi kinerja pengurus dan keuangan koperasi.">
            <div class="avatar">SR</div>
            <h4>H. Slamet Riyadi</h4>
            <span>Ketua Pengawas</span>
        </div>

        <div class="pengawas-card"
             data-name="Nur Aisyah"
             data-role="Anggota Pengawas"
             data-desc="Melakukan pengawasan operasional koperasi.">
            <div class="avatar">NA</div>
            <h4>Nur Aisyah</h4>
            <span>Anggota</span>
        </div>

        <div class="pengawas-card"
             data-name="Rudi Hartono"
             data-role="Anggota Pengawas"
             data-desc="Memastikan pengelolaan sesuai aturan koperasi.">
            <div class="avatar">RH</div>
            <h4>Rudi Hartono</h4>
            <span>Anggota</span>
        </div>

    </div>
</section>

<!-- MODAL PENGAWAS -->
<div class="modal-overlay" id="pengawasModal">
    <div class="modal">
        <button class="close">&times;</button>
        <h3 id="modal-name"></h3>
        <small id="modal-role"></small>
        <p id="modal-desc"></p>
    </div>
</div>

@endsection