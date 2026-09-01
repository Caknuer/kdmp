@extends('layouts.public')

@section('content')
@php
    $getNilaiIcon = function ($title) {
        $t = strtolower(is_array($title) ? ($title['title'] ?? '') : $title);
        if (str_contains($t, 'integritas') || str_contains($t, 'jujur')) return 'fa-shield-alt';
        if (str_contains($t, 'profesional') || str_contains($t, 'ahli')) return 'fa-user-tie';
        if (str_contains($t, 'inovasi') || str_contains($t, 'kreatif')) return 'fa-lightbulb';
        if (str_contains($t, 'gotong') || str_contains($t, 'kebersamaan') || str_contains($t, 'solidaritas')) return 'fa-hands-helping';
        if (str_contains($t, 'transparan') || str_contains($t, 'terbuka')) return 'fa-eye';
        if (str_contains($t, 'adil') || str_contains($t, 'keadilan')) return 'fa-balance-scale';
        if (str_contains($t, 'mandiri') || str_contains($t, 'kemandirian')) return 'fa-seedling';
        return 'fa-star';
    };

    $getNilaiDesc = function ($title) {
        if (is_array($title)) {
            return $title['desc'] ?? '-';
        }
        $t = strtolower($title);
        if (str_contains($t, 'integritas')) return 'Menjunjung tinggi kejujuran, etika, dan keterbukaan dalam seluruh aktivitas koperasi.';
        if (str_contains($t, 'profesionalitas') || str_contains($t, 'profesional')) return 'Bekerja secara kompeten, terukur, dan bertanggung jawab demi kepuasan anggota.';
        if (str_contains($t, 'inovasi')) return 'Terus beradaptasi dan mengembangkan solusi kreatif untuk kemajuan ekonomi desa.';
        if (str_contains($t, 'gotong')) return 'Mengedepankan semangat kebersamaan dan saling tolong menolong antar anggota.';
        if (str_contains($t, 'transparansi')) return 'Pengelolaan keuangan dan operasional yang terbuka serta dapat dipertanggungjawabkan.';
        return 'Prinsip utama yang menjadi landasan operasional dan pelayanan koperasi kepada anggota.';
    };
@endphp

<!-- HERO -->
<section class="page-hero">
  <div class="page-hero-inner">
    <h1>Tentang Koperasi Desa Merah Putih</h1>
    <p>Mengenal lebih dekat peran, visi, misi, dan nilai-nilai Koperasi Desa Merah Putih dalam membangun ekonomi Desa Wonokerto.</p>
  </div>
</section>

<!-- PROFIL SINGKAT -->
<section class="container" style="padding: 50px 0 30px;">
  <div class="card-large" style="background:#fff; border:1px solid #e2e8f0; border-radius:18px; padding:36px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);">
    <h2 style="font-size:1.5rem; font-weight:800; color:#0f172a; margin-bottom:16px;">
        <i class="fas fa-landmark text-danger" style="margin-right:10px;"></i> Profil Singkat KDMP
    </h2>
    <div style="font-size:1.05rem; line-height:1.8; color:#334155; white-space:pre-line;">
        {{ $about?->profil_singkat ?: 'Koperasi Desa Merah Putih (KDMP) didirikan sebagai wadah kebersamaan ekonomi masyarakat Desa Wonokerto, mengelola berbagai unit usaha produktif untuk meningkatkan kesejahteraan bersama secara transparan dan berkelanjutan.' }}
    </div>
  </div>
</section>

<!-- VISI & MISI -->
<section class="container" style="padding: 20px 0 40px;">
  <div class="grid-2" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:24px;">
    <!-- Visi -->
    <div class="card-bordered" style="background:#fff; border:1px solid #e2e8f0; border-radius:18px; padding:32px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);">
      <h3 style="font-size:1.35rem; font-weight:800; color:#0f172a; margin-bottom:14px; display:flex; align-items:center; gap:10px;">
        <span style="display:inline-flex; width:36px; height:36px; border-radius:10px; background:#eff6ff; color:#2563eb; align-items:center; justify-content:center; font-size:1.1rem;">
            <i class="fas fa-bullseye"></i>
        </span>
        Visi Koperasi
      </h3>
      <p style="font-size:1rem; line-height:1.75; color:#475569; white-space:pre-line;">
        {{ $about?->visi ?: 'Menjadi koperasi desa yang mandiri, terpercaya, dan unggul dalam menggerakkan perekonomian masyarakat Desa Wonokerto.' }}
      </p>
    </div>

    <!-- Misi -->
    <div class="card-bordered" style="background:#fff; border:1px solid #e2e8f0; border-radius:18px; padding:32px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);">
      <h3 style="font-size:1.35rem; font-weight:800; color:#0f172a; margin-bottom:14px; display:flex; align-items:center; gap:10px;">
        <span style="display:inline-flex; width:36px; height:36px; border-radius:10px; background:#f0fdf4; color:#16a34a; align-items:center; justify-content:center; font-size:1.1rem;">
            <i class="fas fa-list-check"></i>
        </span>
        Misi Koperasi
      </h3>
      <ul class="list-styled" style="padding-left:20px; line-height:1.8; color:#475569; margin:0;">
        @php
            $misiItems = is_array($about?->misi) ? $about->misi : [];
        @endphp
        @forelse($misiItems as $item)
          <li style="margin-bottom:8px;">{{ $item }}</li>
        @empty
          <li>Mendorong partisipasi aktif seluruh warga dalam kegiatan ekonomi koperasi.</li>
          <li>Mengelola unit-unit bisnis desa secara profesional, transparan, dan akuntabel.</li>
          <li>Membantu permodalan dan pemasaran produk UMKM masyarakat lokal.</li>
        @endforelse
      </ul>
    </div>
  </div>
</section>

<!-- NILAI-NILAI -->
<section class="container" style="padding: 20px 0 60px;">
  <div style="text-align: center; margin-bottom: 36px;">
    <h2 style="font-size:1.6rem; font-weight:800; color:#0f172a; margin-bottom:8px;">Nilai-Nilai Utama KDMP</h2>
    <p style="font-size: 15px; color: #64748b; max-width:600px; margin:0 auto;">Prinsip fundamental yang memandu setiap langkah, keputusan, dan pelayanan kami bagi seluruh anggota.</p>
  </div>

  <div class="grid-4" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:20px;">
    @php
        $nilaiItems = is_array($about?->nilai) ? $about->nilai : [];
    @endphp

    @forelse($nilaiItems as $n)
      @php
          $titleStr = is_array($n) ? ($n['title'] ?? 'Nilai') : $n;
          $iconClass = $getNilaiIcon($n);
          $descStr = $getNilaiDesc($n);
      @endphp
      <div class="card-nilai" style="background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:24px; text-align:center; box-shadow:0 2px 4px rgba(0,0,0,0.03); transition:all 0.2s ease;">
        <div class="nilai-icon" style="width:52px; height:52px; border-radius:14px; background:#fff1f2; color:#e11d48; display:inline-flex; align-items:center; justify-content:center; font-size:1.4rem; margin-bottom:14px;">
            <i class="fas {{ $iconClass }}"></i>
        </div>
        <h4 style="font-size:1.15rem; font-weight:700; color:#0f172a; margin-bottom:8px;">{{ $titleStr }}</h4>
        <p style="font-size:0.875rem; color:#64748b; line-height:1.6; margin:0;">{{ $descStr }}</p>
      </div>
    @empty
      @php
          $defaultNilai = [
              ['title' => 'Integritas', 'desc' => 'Menjunjung tinggi kejujuran dan keterbukaan dalam seluruh aktivitas koperasi.'],
              ['title' => 'Profesionalitas', 'desc' => 'Bekerja secara kompeten, terukur, dan bertanggung jawab demi kepuasan anggota.'],
              ['title' => 'Gotong Royong', 'desc' => 'Mengedepankan semangat kebersamaan dan saling tolong menolong antar anggota.'],
              ['title' => 'Transparansi', 'desc' => 'Pengelolaan keuangan dan operasional yang terbuka serta dapat dipertanggungjawabkan.'],
          ];
      @endphp
      @foreach($defaultNilai as $n)
      <div class="card-nilai" style="background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:24px; text-align:center; box-shadow:0 2px 4px rgba(0,0,0,0.03);">
        <div class="nilai-icon" style="width:52px; height:52px; border-radius:14px; background:#fff1f2; color:#e11d48; display:inline-flex; align-items:center; justify-content:center; font-size:1.4rem; margin-bottom:14px;">
            <i class="fas {{ $getNilaiIcon($n['title']) }}"></i>
        </div>
        <h4 style="font-size:1.15rem; font-weight:700; color:#0f172a; margin-bottom:8px;">{{ $n['title'] }}</h4>
        <p style="font-size:0.875rem; color:#64748b; line-height:1.6; margin:0;">{{ $n['desc'] }}</p>
      </div>
      @endforeach
    @endforelse
  </div>
</section>
@endsection
