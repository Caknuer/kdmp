@extends('layouts.public')

@section('P')
<section class="page-hero page-hero--info">
    <div class="page-hero-inner">
        <span class="hero-pill">Informasi KDMP</span>
        <h1>{{ $article->title }}</h1>
        <p>Dipublikasikan pada {{ $article->display_date->format('d M Y') }}</p>

        <div style="margin-top:14px;">
            <span class="info-tag is-ann">Pengumuman</span>
        </div>
    </div>
</section>

<section class="section section--soft">
    <div class="container">
        <article class="post-detail">
            @if ($article->thumbnail)
                <div class="post-cover">
                    <img
                        src="{{ asset('storage/'.$article->thumbnail) }}"
                        alt="{{ $article->title }}"
                    >
                </div>
            @endif

            <div class="post-content">
                {!! $article->content !!}
            </div>

            <div class="post-actions">
                <a href="{{ url('/pengumuman') }}" class="btn btn--dark">
                    ← Kembali ke daftar pengumuman
                </a>
                <a href="{{ url('/informasi') }}" class="btn">
                    Semua Informasi
                </a>
            </div>
        </article>
    </div>
</section>
@endsection
