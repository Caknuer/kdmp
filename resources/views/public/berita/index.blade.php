@extends('layouts.public')

@section('content')
<section class="page-hero page-hero--info">
    <div class="page-hero-inner">
        <span class="hero-pill">📰 Berita KDMP</span>
        <h1>Berita Terbaru</h1>
        <p>Informasi terkini seputar kegiatan, program, dan perkembangan KDMP Wonokerto</p>
    </div>
</section>

<section class="section section--soft">
    <div class="container">
        <div class="info-grid">
            @forelse ($articles as $article)
                @php
                    $thumbUrl = $article->thumbnail ? asset('storage/' . $article->thumbnail) : null;
                @endphp
                <a href="{{ url('/berita/' . $article->slug) }}" class="info-card">
                    <div class="info-thumb">
                        @if($thumbUrl)
                            <img src="{{ $thumbUrl }}" alt="{{ $article->title }}"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="info-thumb-placeholder" style="display:none;">
                                {{ strtoupper(substr($article->title, 0, 1)) }}
                            </div>
                        @else
                            <div class="info-thumb-placeholder">
                                {{ strtoupper(substr($article->title, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <div class="info-body">
                        <div class="info-meta">
                            <span class="info-tag is-news">📰 Berita</span>
                            <span class="info-date">{{ $article->display_date->format('d M Y') }}</span>
                        </div>

                        <h3 class="info-title">{{ $article->title }}</h3>
                        <p class="info-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($article->content), 120) }}</p>

                        <span class="info-cta">Baca selengkapnya →</span>
                    </div>
                </a>
            @empty
                <div class="info-empty">
                    <h3>Belum ada berita yang dipublikasikan</h3>
                    <p>Silakan cek kembali nanti. Berita terbaru akan muncul di halaman ini.</p>
                    <a class="btn btn--primary" href="{{ url('/pengumuman') }}">Lihat Pengumuman</a>
                </div>
            @endforelse
        </div>

        @if($articles->hasPages())
        <div class="info-pagination">
            {{ $articles->links() }}
        </div>
        @endif
    </div>
</section>
@endsection
