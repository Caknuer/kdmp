@extends('layouts.public')

@section('P')
   <!-- HERO -->
<section class="page-hero">
    <div class="page-hero-inner">
        <h1>Dewan Pengawas KDMP</h1>
        <p>Pengawasan dan pengendalian kinerja koperasi</p>
    </div>
</section>
<section class="org-section alt">
    <div class="container">

        <div class="section-header">
            <h2>Pengawas</h2>
            <p>Pengawas independen untuk menjaga transparansi dan akuntabilitas.</p>
        </div>

        <div class="org-grid">
            @foreach ($pengawas as $item)
                @include('public.partials.org-card', ['item' => $item])
            @endforeach
        </div>

    </div>
</section>

@endsection