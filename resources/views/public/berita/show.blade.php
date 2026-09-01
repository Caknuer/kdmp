@extends('layouts.public')

@section('content')
<section class="page-hero page-hero--info">
    <div class="page-hero-inner">
        <span class="hero-pill">📰 Berita KDMP</span>
        <h1>{{ $article->title }}</h1>
        <p>Dipublikasikan pada {{ $article->display_date->format('d F Y') }}</p>
    </div>
</section>

<section class="section section--soft">
    <div class="container">
        <article class="post-detail bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            @if ($article->thumbnail)
                <div class="post-cover h-64 md:h-96 w-full relative bg-gray-100">
                    <img
                        src="{{ asset('storage/'.$article->thumbnail) }}"
                        alt="{{ $article->title }}"
                        class="w-full h-full object-cover"
                        onerror="this.style.display='none'"
                    >
                </div>
            @endif

            <div class="post-content p-6 md:p-10 prose max-w-none text-gray-700 leading-relaxed">
                {!! $article->content !!}
            </div>

            <div class="post-actions p-6 md:p-10 border-t border-gray-100 bg-gray-50 flex flex-wrap gap-4">
                <a href="{{ url('/berita') }}" class="btn btn--dark">
                    ← Kembali ke daftar berita
                </a>
                <a href="{{ url('/pengumuman') }}" class="btn btn--outline">
                    Lihat Pengumuman
                </a>
                <a href="{{ url('/informasi') }}" class="btn btn--outline">
                    Semua Informasi
                </a>
            </div>
        </article>
    </div>
</section>
@endsection
