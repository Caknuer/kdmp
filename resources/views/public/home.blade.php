@extends('layouts.public')

@section('P')

@include('public.partials.hero')

<!-- RINGKASAN KEUANGAN -->
<section class="summary-section reveal">
    <div class="container">

        @php
            $income = $summary['income'] ?? 0;
            $expense = $summary['expense'] ?? 0;
            $registrationIncome = $summary['registration_income'] ?? 0;
            $balance = $summary['balance'] ?? ($income - $expense);
        @endphp

        <div class="home-head">
            <div>
                <h2 class="home-title">Ringkasan Keuangan</h2>
                <p class="home-subtitle">
                    Ringkasan bulan ini untuk {{ $setting->site_name ?? 'KDMP Wonokerto' }}.
                </p>
            </div>

            <a href="{{ url('/transparansi') }}" class="btn btn--primary">
                Detail Keuangan
            </a>
        </div>

        <div class="summary-grid">
            <div class="summary-card">
                <h4>Uang Masuk</h4>
                <strong>Rp {{ number_format($income, 0, ',', '.') }}</strong>
            </div>

            <div class="summary-card">
                <h4>Uang Keluar</h4>
                <strong>Rp {{ number_format($expense, 0, ',', '.') }}</strong>
            </div>

            <div class="summary-card highlight">
                <h4>Dari Pendaftar Baru</h4>
                <strong>Rp {{ number_format($registrationIncome, 0, ',', '.') }}</strong>
            </div>

            <div class="summary-card total-akhir">
                <h4>Total Akhir</h4>
                <strong>Rp {{ number_format($balance, 0, ',', '.') }}</strong>
            </div>
        </div>

    </div>
</section>


<!-- INFORMASI TERBARU -->
<section class="section section--soft reveal">
    <div class="container">

        <div class="home-head">
            <div>
                <h2 class="home-title">Informasi Terbaru</h2>
                <p class="home-subtitle">Berita & pengumuman terbaru dari {{ $setting->site_name ?? 'KDMP Wonokerto' }}.</p>
            </div>

            <a href="{{ url('/informasi') }}" class="btn btn--primary">
                Lihat semua
            </a>
        </div>

        <div class="info-grid">
            @forelse ($latestInfo as $article)
                @php
                    $base = $article->type === 'pengumuman' ? 'pengumuman' : 'berita';
                @endphp

                <a href="{{ url('/'.$base.'/'.$article->slug) }}" class="info-card">
                    <div class="info-thumb">
                        @if ($article->thumbnail)
                            <img src="{{ asset('storage/'.$article->thumbnail) }}" alt="{{ $article->title }}">
                        @else
                            <div class="info-thumb-placeholder">
                                {{ strtoupper(substr($article->title,0,1)) }}
                            </div>
                        @endif
                    </div>

                    <div class="info-body">
                        <div class="info-meta">
                            <span class="info-tag {{ $article->type === 'pengumuman' ? 'is-ann' : 'is-news' }}">
                                {{ $article->type === 'pengumuman' ? 'Pengumuman' : 'Berita' }}
                            </span>
                            <span class="info-date">{{ $article->display_date->format('d M Y') }}</span>
                        </div>

                        <h3 class="info-title">{{ $article->title }}</h3>
                        <p class="info-excerpt">
                            {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 110) }}
                        </p>

                        <span class="info-cta">Baca selengkapnya →</span>
                    </div>
                </a>
            @empty
                <div class="info-empty">
                    <h3>Belum ada informasi</h3>
                    <p>Informasi terbaru akan tampil di sini setelah dipublikasikan.</p>
                    <a class="btn btn--primary" href="{{ url('/informasi') }}">Buka halaman Informasi</a>
                </div>
            @endforelse
        </div>

    </div>
</section>

@endsection
