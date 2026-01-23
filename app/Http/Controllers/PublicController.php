<?php

namespace App\Http\Controllers;

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
            'articles' => Article::published()
                ->latest('published_at')
                ->limit(4)
                ->get(),


            'summary' => [
                'income'  => Transaction::where('type', 'income')->sum('amount'),
                'expense' => Transaction::where('type', 'expense')->sum('amount'),
            ],

            'setting' => $this->getSettings(), // kirim setting
        ]);
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
            'setting' => $this->getSettings(),
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
            'articles' => Article::published()
                ->orderByDesc('published_at')
                ->paginate(6),
        ]);
    }

    public function articleDetail($slug)
    {
        $article = Article::published()
            ->where('slug', $slug)
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


   /* =======================
   PROFIL PENGURUS
    ======================= */
    public function pengurus()
    {
        $pengurus = OrganizationMember::active()
            ->pengurus()
            ->orderBy('order')
            ->get();

        return view('public.profil.pengurus', compact('pengurus'));
    }

    /* =======================
    PROFIL PENGAWAS
    ======================= */
    public function pengawas()
    {
        $pengawas = OrganizationMember::active()
            ->pengawas()
            ->orderBy('order')
            ->get();

        return view('public.profil.pengawas', compact('pengawas'));
    }

    /* =======================
    Fungsi helper untuk Setting
    ======================= */
    protected function getSettings()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return (object) [
            'site_name' => $settings['site_name'] ?? null,
            'address' => $settings['address'] ?? null,
            'phone' => $settings['phone'] ?? null,
            'email' => $settings['email'] ?? null,
            'website' => $settings['website'] ?? null,
            'footer_description' => $settings['footer_description'] ?? null,
            'gmaps' => $settings['gmaps'] ?? null,
        ];
    }
}
