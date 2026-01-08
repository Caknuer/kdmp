@extends('layouts.public')

@section('P')
    
<<section class="container" style="margin-top:120px">

    <article class="berita-detail">

        <h1>{{ $article->title }}</h1>

        <div class="meta">
            Dipublikasikan pada
            {{ $article->created_at->format('d M Y') }}
        </div>

        <div class="content">
            {!! $article->content !!}
        </div>

        <a href="{{ url('/artikel') }}" class="back-link">
            ← Kembali ke daftar berita
        </a>

    </article>

</section>
@endsection
