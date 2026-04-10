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
    <p>
      @if(is_array($about?->profil_singkat))
        {{ implode(', ', $about->profil_singkat) }}
      @else
        {{ $about?->profil_singkat ?? 'Belum ada data.' }}
      @endif
    </p>
  </div>
</section>

<!-- VISI & MISI (EDITABLE) -->
<section class="container">
  <div class="row">
    <div class="card">
      <h3>Visi</h3>
      <p>
        @if(is_array($about?->visi))
          {{ implode(', ', $about->visi) }}
        @else
          {{ $about?->visi ?? 'Belum ada data.' }}
        @endif
      </p>
    </div>

    <div class="card">
      <h3>Misi</h3>
      <ul class="list">
        @forelse($about?->misi ?? [] as $misi)
          @if(is_array($misi))
            <li>{{ json_encode($misi) }}</li>
          @else
            <li>{{ $misi }}</li>
          @endif
        @empty
          <li>Belum ada data misi.</li>
        @endforelse
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
    @forelse($about?->nilai ?? [] as $n)
      <div class="card">
        <h4>{{ $n['icon'] ?? '' }} {{ $n['title'] ?? '' }}</h4>
        <p>{{ $n['desc'] ?? '' }}</p>
      </div>
    @empty
      <p>Belum ada data nilai.</p>
    @endforelse
  </div>
</section>
@endsection