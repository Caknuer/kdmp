@extends('layouts.public')

@section('content')
<section class="page-hero page-hero--info">
    <div class="page-hero-inner">
        <span class="hero-pill">📢 Pengumuman KDMP</span>
        <h1>Pengumuman Terbaru</h1>
        <p>Pengumuman resmi dan informasi penting dari KDMP Wonokerto</p>
    </div>
</section>

<section class="section section--soft">
    <div class="container">
        <div class="info-grid">
            @forelse ($articles as $article)
                <a href="{{ url('/pengumuman/'.$article->slug) }}" class="info-card">
                    <div class="info-thumb">
                        @if ($article->thumbnail)
                            <img
                                src="{{ asset('storage/'.$article->thumbnail) }}"
                                alt="{{ $article->title }}"
                            >
                        @else
                            <div class="info-thumb-placeholder">
                                {{ strtoupper(substr($article->title,0,1)) }}
                            </div>
                        @endif
                    </div>

                    <div class="info-body">
                        <div class="info-meta">
                            <span class="info-tag is-ann">📢 Pengumuman</span>
                            <span class="info-date">{{ $article->display_date->format('d M Y') }}</span>
                        </div>

                        <h3 class="info-title">{{ $article->title }}</h3>
                        <p class="info-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($article->content), 110) }}</p>

                        <span class="info-cta">Baca selengkapnya →</span>
                    </div>
                </a>
            @empty
                <div class="info-empty">
                    <h3>Belum ada pengumuman yang dipublikasikan</h3>
                    <p>Silakan cek kembali nanti. Pengumuman terbaru akan muncul di halaman ini.</p>
                    <a class="btn btn--primary" href="{{ url('/informasi') }}">Lihat Semua Informasi</a>
                </div>
            @endforelse
        </div>

        <div class="info-pagination">
            {{ $articles->links() }}
        </div>
    </div>
</section>
@endsection
