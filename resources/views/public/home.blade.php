@extends('layouts.public')

@section('P')

@include('public.partials.hero')

<!-- RINGKASAN TABUNGAN -->
<section class="summary-section reveal">
    <div class="container summary-grid">

        <div class="summary-card">
            <h4>Total Setoran</h4>
            <strong>
                Rp {{ number_format($summary['credit'] ?? 0, 0, ',', '.') }}
            </strong>
        </div>

        <div class="summary-card">
            <h4>Total Penarikan</h4>
            <strong>
                Rp {{ number_format($summary['debit'] ?? 0, 0, ',', '.') }}
            </strong>
        </div>

        <div class="summary-card total-akhir">
            <h4>Saldo Akhir</h4>
            <strong>
                Rp {{ number_format(($summary['credit'] ?? 0) - ($summary['debit'] ?? 0), 0, ',', '.') }}
            </strong>
        </div>

        <div class="summary-card highlight">
            <h4>Status Program</h4>
            <strong>Tabungan Aktif</strong>
        </div>

    </div>
</section>

<!-- BERITA -->
<section class="news-section reveal">
    <div class="container">

        <div class="section-header">
            <h2>
                <a href="{{ route('articles') }}" class="section-title-link">Berita Terbaru</a>
            </h2>
        </div>

        @if ($articles->count())
            <div class="news-list">
                @foreach ($articles as $article)
                    <article class="news-card">

                        @if ($article->thumbnail)
                            <div class="news-thumbnail">
                                <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}">
                            </div>
                        @endif

                        <div class="news-content">
                            <h3>{{ $article->title }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($article->content), 150) }}</p>
                            <a href="{{ route('articles.detail', $article->slug) }}" class="read-more">Baca →</a>
                        </div>

                    </article>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <p>Belum ada berita yang dipublikasikan.</p>
            </div>
        @endif

    </div>
</section>

@endsection
