<h1 class="text-2xl font-bold">{{ $article->title }}</h1>
<img src="{{ asset('storage/'.$article->thumbnail) }}" class="my-4"/>
<p>{!! $article->body !!}</p>
