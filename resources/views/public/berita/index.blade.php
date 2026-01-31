@extends('layouts.public')

@section('P')
<section class="page-hero">
    <div class="page-hero-inner">
        <h1>Berita</h1>
        <p>Informasi terbaru seputar kegiatan dan perkembangan KDMP</p>
    </div>
</section>

<section class="container">
    <div class="row berita-grid">
        @forelse ($articles as $article)
            <a href="{{ url('/berita/'.$article->slug) }}" class="berita-card">
                <div class="berita-thumb">
                    @if ($article->thumbnail)
                        <img
                            src="{{ asset('storage/'.$article->thumbnail) }}"
                            alt="{{ $article->title }}"
                            style="width:100%;height:100%;object-fit:cover;border-radius:12px;"
                        >
                    @else
                        {{ strtoupper(substr($article->title,0,1)) }}
                    @endif
                </div>

                <div class="berita-body">
                    <h3>{{ $article->title }}</h3>
                    <small>{{ $article->display_date->format('d M Y') }}</small>
                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($article->content), 100) }}</p>
                </div>
            </a>
        @empty
            <div class="empty-state">
                Belum ada berita yang dipublikasikan.
            </div>
        @endforelse
    </div>

    <div style="margin-top:30px">
        {{ $articles->links() }}
    </div>
</section>
@endsection
