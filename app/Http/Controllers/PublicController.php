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
            'articles' => Article::where('status', 'published')
                                ->latest()
                                ->take(4)
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
        return view('public.unit-bisnis.index', [
            'units' => BusinessUnit::where('is_active', true)
                ->orderBy('order')
                ->get(),
        ]);
    }

    public function businessDetail($slug)
    {
        return view('public.unit-bisnis.detail', [
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
            'partners' => Partner::all(),
        ]);
    }

    /* =======================
       ARTIKEL / BERITA
    ======================== */
    public function articles()
    {
        return view('public.articles.index', [
            'articles' => Article::where('status', 'published')
                                ->latest()
                                ->paginate(6),
        ]);
    }

    public function articleDetail($slug)
    {
        return view('public.articles.detail', [
            'article' => Article::where('slug', $slug)->firstOrFail(),
        ]);
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
