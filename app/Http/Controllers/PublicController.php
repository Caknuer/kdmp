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

            // Ringkasan tabungan global (untuk homepage)
            'summary' => [
                'credit' => Transaction::where('type', 'credit')->sum('amount'),
                'debit'  => Transaction::where('type', 'debit')->sum('amount'),
            ],

            'setting' => $this->getSettings(),
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

            'setting' => $this->getSettings(),
        ]);
    }

    /* =======================
       MITRA
    ======================== */
    public function partners()
    {
        return view('public.partners', [
            'partners' => Partner::where('is_active', true)->get(),
            'setting' => $this->getSettings(),
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

            'setting' => $this->getSettings(),
        ]);
    }

    public function articleDetail($slug)
    {
        $article = Article::published()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('public.articles.show', [
            'article' => $article,
            'setting' => $this->getSettings(),
        ]);
    }

    /* =======================
       PROFIL PENGURUS
    ======================== */
    public function pengurus()
    {
        $pengurus = OrganizationMember::active()
            ->pengurus()
            ->orderBy('order')
            ->get();

        return view('public.profil.pengurus', [
            'pengurus' => $pengurus,
            'setting' => $this->getSettings(),
        ]);
    }

    /* =======================
       PROFIL PENGAWAS
    ======================== */
    public function pengawas()
    {
        $pengawas = OrganizationMember::active()
            ->pengawas()
            ->orderBy('order')
            ->get();

        return view('public.profil.pengawas', [
            'pengawas' => $pengawas,
            'setting' => $this->getSettings(),
        ]);
    }

    /* =======================
       Helper Setting
    ======================== */
    protected function gmapsEmbedFromUrl(?string $url): ?string
    {
        if (!$url) return null;

        if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+),(\d+(\.\d+)?)z/', $url, $m)) {
            $lat = $m[1];
            $lng = $m[2];
            $zoom = (int) $m[3];
            return "https://www.google.com/maps?q={$lat},{$lng}&z={$zoom}&output=embed";
        }

        if (str_contains($url, 'google.com/maps')) {
            $join = str_contains($url, '?') ? '&' : '?';
            return $url . $join . 'output=embed';
        }

        return null;
    }

    protected function getSettings()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $gmapsUrl = $settings['gmaps_url'] ?? null;

        return (object) [
            'site_name' => $settings['site_name'] ?? null,
            'address' => $settings['address'] ?? null,
            'phone' => $settings['phone'] ?? null,
            'email' => $settings['email'] ?? null,
            'footer_description' => $settings['footer_description'] ?? null,

            'gmaps_url' => $gmapsUrl,
            'gmaps_embed_src' => $this->gmapsEmbedFromUrl($gmapsUrl),
        ];
    }
}
