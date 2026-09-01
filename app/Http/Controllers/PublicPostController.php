<?php

namespace App\Http\Controllers;

use App\Models\Article;

class PublicPostController extends Controller
{
    public function beritaIndex()
    {
        $articles = Article::published()
            ->type('berita')
            ->latest('published_at')
            ->paginate(9);

        return view('public.berita.index', [
            'pageTitle' => 'Berita',
            'pageDescription' => 'Berita terbaru dari KDMP Wonokerto.',
            'articles' => $articles,
        ]);
    }

    public function beritaShow(string $slug)
    {
        $article = Article::published()
            ->type('berita')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('public.berita.show', [
            'pageTitle' => $article->title,
            'pageDescription' => \Illuminate\Support\Str::limit(strip_tags($article->content), 160),
            'article' => $article,
        ]);
    }

    public function pengumumanIndex()
    {
        $articles = Article::published()
            ->type('pengumuman')
            ->latest('published_at')
            ->paginate(9);

        return view('public.pengumuman.index', [
            'pageTitle' => 'Pengumuman',
            'pageDescription' => 'Pengumuman resmi dari KDMP Wonokerto.',
            'articles' => $articles,
        ]);
    }

    public function pengumumanShow(string $slug)
    {
        $article = Article::published()
            ->type('pengumuman')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('public.pengumuman.show', [
            'pageTitle' => $article->title,
            'pageDescription' => \Illuminate\Support\Str::limit(strip_tags($article->content), 160),
            'article' => $article,
        ]);
    }

    // OPTIONAL: redirect route lama /artikel ke /berita
    public function artikelRedirect()
    {
        return redirect('/berita', 301);
    }

    public function artikelShowRedirect(string $slug)
    {
        // cari dulu termasuk tipe apa, lalu redirect
        $article = Article::where('slug', $slug)->first();

        if (! $article) {
            abort(404);
        }

        $path = $article->type === 'pengumuman'
            ? '/pengumuman/' . $article->slug
            : '/berita/' . $article->slug;

        return redirect($path, 301);
    }

    public function informasiIndex()
    {
        $articles = Article::published()
            ->latest('published_at')
            ->paginate(9);

        return view('public.informasi.index', compact('articles'));
    }

    public function informasiShow(string $slug)
    {
        $article = Article::published()
            ->type('informasi')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('public.informasi.show', [
            'pageTitle' => $article->title,
            'pageDescription' => \Illuminate\Support\Str::limit(strip_tags($article->content), 160),
            'article' => $article,
        ]);
    }
}
