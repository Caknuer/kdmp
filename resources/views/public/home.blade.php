@extends('layouts.public')

@section('P')

@include('public.partials.hero')

<div class="container">

    <h1 class="page-title">Koperasi Desa Merah Putih</h1>

    <div class="row">

        <!-- Kolom Berita -->
        <div class="card">
            <h2 class="card-title">Berita Terbaru</h2>

            @foreach ($articles as $article)
                <a href="{{ route('articles.detail', $article->slug) }}" class="article-item">
                    <h3 class="article-title">{{ $article->title }}</h3>
                    <p class="article-excerpt">{{ $article->excerpt }}</p>
                </a>
            @endforeach
        </div>

        <!-- Kolom Transparansi -->
        <div class="card">
            <h2 class="card-title">Transparansi Singkat</h2>

            <p><strong>Total Pemasukan:</strong> Rp {{ number_format($summary['income'] ?? 0) }}</p>
            <p><strong>Total Pengeluaran:</strong> Rp {{ number_format($summary['expense'] ?? 0) }}</p>
        </div>

    </div>
</div>

@endsection
