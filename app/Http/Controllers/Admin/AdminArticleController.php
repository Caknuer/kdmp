<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Admin Article Controller
 *
 * Manages CRUD operations for articles (berita, pengumuman, informasi).
 * Supports thumbnail upload, published_at scheduling, and type filtering.
 *
 * @package App\Http\Controllers\Admin
 */
class AdminArticleController extends Controller
{
    /**
     * Display list of all articles with search and filter
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status', 'all');
        $type   = $request->get('type', 'all');

        $query = Article::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($status === 'published') {
            $query->where('is_published', true);
        } elseif ($status === 'draft') {
            $query->where('is_published', false);
        }

        if ($type !== 'all') {
            $query->where('type', $type);
        }

        $articles = $query->orderBy('created_at', 'desc')->paginate(15);

        // Stats
        $totalArticles     = Article::count();
        $totalBerita       = Article::where('type', 'berita')->count();
        $totalPengumuman   = Article::where('type', 'pengumuman')->count();
        $totalInformasi    = Article::where('type', 'informasi')->count();
        $totalPublished    = Article::where('is_published', true)->count();
        $totalDraft        = Article::where('is_published', false)->count();

        return view('admin.articles.index', compact(
            'articles',
            'search',
            'status',
            'type',
            'totalArticles',
            'totalBerita',
            'totalPengumuman',
            'totalInformasi',
            'totalPublished',
            'totalDraft'
        ));
    }

    /**
     * Show form for creating new article
     */
    public function create(Request $request)
    {
        $defaultType = $request->get('type', '');

        return view('admin.articles.create', compact('defaultType'));
    }

    /**
     * Store a new article in database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'content'      => ['required', 'string'],
            'type'         => ['required', 'in:berita,informasi,pengumuman'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'thumbnail'    => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp,gif', 'max:2048'],
        ], [
            'title.required'   => 'Judul artikel wajib diisi.',
            'content.required' => 'Konten artikel wajib diisi.',
            'type.required'    => 'Tipe artikel wajib dipilih.',
            'type.in'          => 'Tipe artikel tidak valid.',
            'thumbnail.image'  => 'Thumbnail harus berupa file gambar.',
            'thumbnail.max'    => 'Thumbnail maksimal 2MB.',
        ]);

        // Slug unik
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }
        $validated['slug'] = $slug;

        // Published at
        $isPublished = !empty($validated['is_published']);
        $validated['is_published'] = $isPublished;

        if ($isPublished) {
            $validated['published_at'] = !empty($validated['published_at'])
                ? $validated['published_at']
                : now();
        } else {
            $validated['published_at'] = null;
        }

        // Thumbnail
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('articles', 'public');
        }

        $article = Article::create($validated);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', "Artikel \"{$article->title}\" berhasil ditambahkan!");
    }

    /**
     * Show article details
     */
    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    /**
     * Show form for editing article
     */
    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    /**
     * Update article in database
     */
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'content'      => ['required', 'string'],
            'type'         => ['required', 'in:berita,informasi,pengumuman'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'thumbnail'    => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp,gif', 'max:2048'],
        ], [
            'title.required'   => 'Judul artikel wajib diisi.',
            'content.required' => 'Konten artikel wajib diisi.',
            'type.required'    => 'Tipe artikel wajib dipilih.',
            'thumbnail.image'  => 'Thumbnail harus berupa file gambar.',
            'thumbnail.max'    => 'Thumbnail maksimal 2MB.',
        ]);

        // Slug jika judul berubah
        if ($validated['title'] !== $article->title) {
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $counter = 1;
            while (Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }
            $validated['slug'] = $slug;
        }

        // Published at
        $isPublished = !empty($validated['is_published']);
        $validated['is_published'] = $isPublished;

        if ($isPublished && empty($article->published_at)) {
            $validated['published_at'] = !empty($validated['published_at'])
                ? $validated['published_at']
                : now();
        } elseif ($isPublished && !empty($validated['published_at'])) {
            $validated['published_at'] = $validated['published_at'];
        } elseif (!$isPublished) {
            $validated['published_at'] = null;
        }

        // Hapus thumbnail
        if ($request->has('remove_thumbnail') && $request->remove_thumbnail == '1') {
            if ($article->thumbnail && Storage::disk('public')->exists($article->thumbnail)) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $validated['thumbnail'] = null;
        }

        // Upload thumbnail baru
        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail && Storage::disk('public')->exists($article->thumbnail)) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('articles', 'public');
        }

        $article->update($validated);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', "Artikel \"{$article->title}\" berhasil diperbarui!");
    }

    /**
     * Delete article from database
     */
    public function destroy(Article $article)
    {
        $title = $article->title;

        if ($article->thumbnail && Storage::disk('public')->exists($article->thumbnail)) {
            Storage::disk('public')->delete($article->thumbnail);
        }

        $article->delete();

        return redirect()
            ->route('admin.articles.index')
            ->with('success', "Artikel \"{$title}\" berhasil dihapus!");
    }
}
