@extends('layouts.public')

@section('P')
<section class="container" style="margin-top:120px">
    <article class="berita-detail">
        <h1>{{ $article->title }}</h1>

        <div class="meta">
            Dipublikasikan pada {{ $article->display_date->format('d M Y') }}
        </div>

        @if ($article->thumbnail)
            <div style="margin:16px 0;">
                <img
                    src="{{ asset('storage/'.$article->thumbnail) }}"
                    alt="{{ $article->title }}"
                    style="width:100%;max-height:420px;object-fit:cover;border-radius:16px;"
                >
            </div>
        @endif

        <div class="content">
            {!! $article->content !!}
        </div>

        <a href="{{ url('/pengumuman') }}" class="back-link">
            ← Kembali ke daftar pengumuman
        </a>
    </article>
</section>
@endsection
