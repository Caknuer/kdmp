@extends('layouts.public')

@section('P')
       <!-- HERO -->
<section class="page-hero">
    <div class="page-hero-inner">
        <h1>Berita & Informasi</h1>
        <p>Informasi terbaru seputar kegiatan dan perkembangan KDMP</p>
    </div>
</section>

<!-- LIST BERITA -->
<section class="container">
    <div class="row berita-grid">

        @forelse ($articles as $article)
            <a href="{{ url('/artikel/'.$article->slug) }}" class="berita-card">
                <div class="berita-thumb">
                    {{ strtoupper(substr($article->title,0,1)) }}
                </div>

                <div class="berita-body">
                    <h3>{{ $article->title }}</h3>
                    <small>
                        {{ $article->created_at->format('d M Y') }}
                    </small>
                    <p>
                        {{ Str::limit(strip_tags($article->content), 100) }}
                    </p>
                </div>
            </a>
        @empty
            <div class="empty-state">
                Belum ada berita yang dipublikasikan.
            </div>
        @endforelse

    </div>

    <!-- PAGINATION -->
    <div style="margin-top:30px">
        {{ $articles->links() }}
    </div>
</section>

@endsection
