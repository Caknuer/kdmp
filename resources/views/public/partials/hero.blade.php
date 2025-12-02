<div class="hero">
    <div class="container hero-content">
        <h1>Koperasi Desa Merah Putih</h1>
        <p>Membangun kemandirian ekonomi masyarakat desa melalui kolaborasi & inovasi.</p>
        <a href="/profil/tentang-kdmp" class="btn-primary">Selengkapnya</a>
    </div>
</div>

<div class="container section">

    <h2 class="section-title">Berita Terbaru</h2>

    <div class="card-grid">
        @foreach ($articles as $article)
        <a href="/berita/{{ $article->slug }}" class="card">
            <img src="{{ asset('storage/'.$article->thumbnail) }}" alt="">
            <div class="card-body">
                <h3>{{ $article->title }}</h3>
                <p>{{ $article->excerpt }}</p>
            </div>
        </a>
        @endforeach
    </div>

</div>
