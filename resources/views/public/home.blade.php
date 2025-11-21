<x-public-layout>

<div class="container mx-auto px-4 py-10">

    <h1 class="text-3xl font-bold mb-6">Koperasi Desa Merah Putih</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-5 shadow rounded">
            <h2 class="text-xl font-semibold mb-3">Berita Terbaru</h2>

            @foreach ($articles as $article)
                <a href="{{ route('articles.detail', $article->slug) }}" class="block mb-3">
                    <h3 class="font-bold">{{ $article->title }}</h3>
                    <p class="text-sm text-gray-600">{{ $article->excerpt }}</p>
                </a>
            @endforeach
        </div>

        <div class="bg-white p-5 shadow rounded">
            <h2 class="text-xl font-semibold mb-3">Transparansi Singkat</h2>
            <p>Total Pemasukan: Rp {{ number_format($summary['income'] ?? 0) }}</p>
            <p>Total Pengeluaran: Rp {{ number_format($summary['expense'] ?? 0) }}</p>
        </div>
    </div>

</div>

</x-public-layout>
