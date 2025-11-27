@foreach ($articles as $article)
    <h1 class="text-2xl font-bold">{{ $article->title }}</h1>
    <img src="{{ asset('storage/' . $article->thumbnail) }}" class="my-4"/>
    <p>{{ Str::limit(strip_tags($article->body), 200) }}</p>

    <a href="{{ route('public.articles.show', $article->slug) }}" class="text-blue-600">
        Baca selengkapnya →
    </a>

    <hr class="my-6">
@endforeach
