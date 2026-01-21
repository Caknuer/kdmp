@extends('layouts.public')

@section('P')

<!-- HERO -->
<section class="page-hero">
    <div class="page-hero-inner">
        <h1>Pengurus KDMP</h1>
        <p>Struktur pengelola Koperasi Desa Merah Putih</p>
    </div>
</section>

<section class="org-section">
    <div class="container">

        <div class="section-header">
            <h2>Pengurus KDMP</h2>
            <p>Pengelola utama yang bertanggung jawab atas kegiatan dan operasional.</p>
        </div>

        <div class="org-grid">
            @foreach ($pengurus as $item)
                @include('public.partials.org-card', ['item' => $item])
            @endforeach
        </div>

    </div>
</section>


@endsection