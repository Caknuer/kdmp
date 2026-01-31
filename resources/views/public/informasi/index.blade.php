@extends('layouts.public')

@section('P')
<section class="page-hero">
    <div class="page-hero-inner">
        <h1>Informasi</h1>
        <p>Berita dan pengumuman terbaru dari KDMP</p>
    </div>
</section>

<section class="container">
    <div class="row berita-grid">

        @forelse ($articles as $article)
            @php
                $base = $article->type === 'pengumuman' ? 'pengumuman' : 'berita';
            @endphp

            <a href="{{ url('/'.$base.'/'.$article->slug) }}" class="berita-card">

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
                    <small style="display:inline-block;margin-bottom:6px;">
                        {{ $article->type === 'pengumuman' ? 'Pengumuman' : 'Berita' }}
                        • {{ $article->display_date->format('d M Y') }}
                    </small>

                    <h3>{{ $article->title }}</h3>

                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($article->content), 100) }}</p>
                </div>

            </a>
        @empty
            <div class="empty-state">
                Belum ada informasi yang dipublikasikan.
            </div>
        @endforelse

    </div>

    <div style="margin-top:30px">
        {{ $articles->links() }}
    </div>
</section>
@endsection
