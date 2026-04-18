@extends('layouts.public')

@section('P')
<!-- HERO -->
<section class="page-hero">
  <div class="page-hero-inner">
    <h1>Tentang Koperasi Desa Merah Putih</h1>
    <p>Mengenal lebih dekat peran, tujuan, dan nilai Koperasi Desa Merah Putih dalam membangun ekonomi Desa Wonokerto.</p>
  </div>
</section>

<!-- PROFIL SINGKAT -->
<section class="container" style="padding: 60px 0;">
  <div class="card-large">
    <h2>Profil Singkat KDMP</h2>
    <p>{{ $about?->profil_singkat ?? 'Belum ada data profil.' }}</p>
  </div>
</section>

<!-- VISI & MISI -->
<section class="container" style="padding: 60px 0;">
  <div class="grid-2">
    <div class="card-bordered">
      <h3>Visi</h3>
      <p>{{ $about?->visi ?? 'Belum ada data visi.' }}</p>
    </div>

    <div class="card-bordered">
      <h3>Misi</h3>
      <ul class="list-styled">
        @forelse($about?->misi ?? [] as $item)
          <li>{{ $item }}</li>
        @empty
          <li>Belum ada data misi.</li>
        @endforelse
      </ul>
    </div>
  </div>
</section>

<!-- NILAI-NILAI -->
<section class="container" style="padding: 60px 0; margin-bottom: 40px;">
  <div style="text-align: center; margin-bottom: 40px;">
    <h2>Nilai-Nilai KDMP</h2>
    <p style="font-size: 16px; color: #6b7280;">Prinsip-prinsip fundamental yang memandu setiap keputusan dan tindakan kami.</p>
  </div>

  <div class="grid-4">
    @forelse($about?->nilai ?? [] as $n)
      <div class="card-nilai">
        <div class="nilai-icon">{{ $n['icon'] ?? '🎯' }}</div>
        <h4>{{ $n['title'] ?? 'Nilai' }}</h4>
        <p>{{ $n['desc'] ?? '-' }}</p>
      </div>
    @empty
      <p style="grid-column: 1/-1; text-align: center; color: #9ca3af;">Belum ada data nilai.</p>
    @endforelse
  </div>
</section>
@endsection
