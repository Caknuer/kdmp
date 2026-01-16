<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Article;
use App\Models\BusinessUnit;
use App\Models\Partner;
use App\Models\Transaction;
use App\Models\Setting;
use App\Models\OrganizationMember;

class PublicController extends Controller
{
    /* =======================
       BERANDA
    ======================== */
    public function home()
    {
        return view('public.home', [
            'articles' => Article::whereNotNull('published_at')
                        ->where('published_at', '<=', now())
                        ->latest('published_at')
                        ->limit(4)
                        ->get(),

            'summary' => [
                'income'  => Transaction::where('type', 'income')->sum('amount'),
                'expense' => Transaction::where('type', 'expense')->sum('amount'),
            ],

             'setting' => Setting::first(),
        ]);
    }

    /* =======================
       PROFIL
    ======================== */
    public function profile($slug)
    {
        $data = Profile::where('slug', $slug)->firstOrFail();
        return view('public.profile', compact('data'));
    }

    /* =======================
       UNIT BISNIS
    ======================== */
    public function businessUnits()
    {
        return view('public.business.index', [
            'units' => BusinessUnit::where('is_active', true)
                ->orderBy('order')
                ->get(),
        ]);
    }

    public function businessDetail($slug)
    {
        return view('public.business.detail', [
            'unit' => BusinessUnit::where('slug', $slug)
                ->where('is_active', true)
                ->firstOrFail(),
        ]);
    }

    /* =======================
       MITRA
    ======================== */
    public function partners()
    {
        return view('public.partners', [
            'partners' => Partner::where('is_active', true)
            ->orderBy()
            ->get(),
        ]);
    }

    /* =======================
       ARTIKEL / BERITA
    ======================== */
    public function articles()
    {
        return view('public.articles.index', [
            'articles' => Article::where('is_published')
                    ->whereNotNull('published_at', '<=', now())
                    ->orderByDesc('published_at')
                    ->paginate(6),
        ]);
    }

    public function articleDetail($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('public.articles.show', compact('article'));
    }

    /* =======================
       TRANSPARANSI KEUANGAN
    ======================== */
    public function finance()
    {
        return view('public.finance', [
            'summary' => [
                'income'  => Transaction::where('type', 'income')->sum('amount'),
                'expense' => Transaction::where('type', 'expense')->sum('amount'),
            ],
            'transactions' => Transaction::latest()->paginate(20),
        ]);
    }


    public function organisasi()
    {
        return view('pages.organisasi', [
            'pengurus' => OrganizationMember::where('type', 'pengurus')
                ->where('is_active', true)
                ->orderBy('order')
                ->get(),

            'pengawas' => OrganizationMember::where('type', 'pengawas')
                ->where('is_active', true)
                ->orderBy('order')
                ->get(),
        ]);
    }

}
