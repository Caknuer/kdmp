@extends('layouts.public')

@section('P')
<!-- HERO (TIDAK DIEDIT ADMIN) -->
<section class="page-hero">
  <div class="page-hero-inner">
    <h1>Tentang Koperasi Desa Merah Putih</h1>
    <p>
      Mengenal lebih dekat peran, tujuan, dan nilai Koperasi Desa Merah Putih
      dalam membangun ekonomi Desa Wonokerto.
    </p>
  </div>
</section>

<!-- PROFIL SINGKAT (EDITABLE) -->
<section class="container">
  <div class="about-box">
    <h2>Profil Singkat KDMP</h2>
    <p>{{ $about?->profil_singkat }}</p>
  </div>
</section>

<!-- VISI & MISI (EDITABLE) -->
<section class="container">
  <div class="row">
    <div class="card">
      <h3>Visi</h3>
      <p>{{ $about?->visi }}</p>
    </div>

    <div class="card">
      <h3>Misi</h3>
      <ul class="list">
        @foreach(($about?->misi ?? []) as $misi)
            <li>{{ $misi }}</li>
        @endforeach
      </ul>
    </div>
  </div>
</section>

<!-- NILAI-NILAI (EDITABLE) -->
<section class="container">
  <div class="section-header">
    <h2>Nilai-Nilai KDMP</h2>
  </div>

  <div class="row">
    @foreach(($about?->nilai ?? []) as $n)
      <div class="card">
        <h4>{{ $n['icon'] ?? '' }} {{ $n['title'] ?? '' }}</h4>
        <p>{{ $n['desc'] ?? '' }}</p>
      </div>
    @endforeach
  </div>
</section>
@endsection
