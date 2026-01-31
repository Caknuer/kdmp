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

        return view('public.berita.index', compact('articles'));
    }

    public function beritaShow(string $slug)
    {
        $article = Article::published()
            ->type('berita')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('public.berita.show', compact('article'));
    }

    public function pengumumanIndex()
    {
        $articles = Article::published()
            ->type('pengumuman')
            ->latest('published_at')
            ->paginate(9);

        return view('public.pengumuman.index', compact('articles'));
    }

    public function pengumumanShow(string $slug)
    {
        $article = Article::published()
            ->type('pengumuman')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('public.pengumuman.show', compact('article'));
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
}
