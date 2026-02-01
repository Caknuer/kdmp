<?php

namespace App\Http\Controllers;

use App\Models\AboutPage;
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
        $units = BusinessUnit::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->select(['id', 'name', 'slug', 'thumbnail', 'description', 'is_active', 'order'])
            ->get();

        if ($units->isEmpty()) {
            $units = $this->dummyBusinessUnits();
        }

        return view('public.business.index', [
            'units' => $units,
            'setting' => $this->getSettings(),
        ]);
    }

    public function businessDetail(string $slug)
    {
        $unit = BusinessUnit::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->select(['id', 'name', 'slug', 'thumbnail', 'description', 'is_active', 'order'])
            ->first();

        $isDummy = false;

        if (! $unit) {
            $unit = $this->findDummyBusinessUnitBySlug($slug);
            abort_if(! $unit, 404);
            $isDummy = true;
        }

        return view('public.business.detail', [
            'unit' => $unit,
            'isDummy' => $isDummy,
            'setting' => $this->getSettings(),
        ]);
    }

    /* =======================
       DUMMY UNIT BISNIS
    ======================== */
    protected function dummyBusinessUnits()
    {
        return collect([
            (object)[
                'id' => null,
                'name' => 'Unit Simpan Pinjam',
                'slug' => 'unit-simpan-pinjam',
                'thumbnail' => null,
                'description' => "Melayani simpan pinjam anggota dengan prinsip koperasi.\nProses transparan dan pelayanan cepat.",
                'is_active' => true,
                'order' => 1,
            ],
            (object)[
                'id' => null,
                'name' => 'Unit Perdagangan',
                'slug' => 'unit-perdagangan',
                'thumbnail' => null,
                'description' => "Mengelola penjualan kebutuhan masyarakat dan pemasaran produk UMKM desa.",
                'is_active' => true,
                'order' => 2,
            ],
            (object)[
                'id' => null,
                'name' => 'Unit Produksi',
                'slug' => 'unit-produksi',
                'thumbnail' => null,
                'description' => "Mengolah potensi desa menjadi produk bernilai tambah.",
                'is_active' => true,
                'order' => 3,
            ],
        ]);
    }

    protected function findDummyBusinessUnitBySlug(string $slug)
    {
        return $this->dummyBusinessUnits()->firstWhere('slug', $slug);
    }

    /* =======================
       MITRA / PARTNER
       (FIX: tanpa kolom description di DB)
    ======================== */
    public function partners()
    {
        $partners = Partner::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->select([
                'id',
                'name',
                'logo',
                'website',
                'is_active',
                'sort_order',
            ])
            ->get()
            ->map(function ($p) {
                // Normalisasi website (biar link aman)
                $p->website = $this->normalizeUrl($p->website);

                // Karena kolom description belum ada di DB,
                // set null biar Blade/Modal aman jika akses $partner->description
                $p->description = null;

                return $p;
            });

        if ($partners->isEmpty()) {
            $partners = $this->dummyPartners();
        }

        return view('public.partners', [
            'partners' => $partners,
            'setting' => $this->getSettings(),
        ]);
    }

    protected function dummyPartners()
    {
        return collect([
            (object)[
                'id' => null,
                'name' => 'BUMDes Wonokerto',
                'logo' => null,
                'website' => $this->normalizeUrl('example.com'),
                'description' => 'Mitra strategis dalam pengelolaan usaha desa.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            (object)[
                'id' => null,
                'name' => 'UMKM Makmur',
                'logo' => null,
                'website' => null,
                'description' => 'Mendukung pengembangan produk lokal desa.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            (object)[
                'id' => null,
                'name' => 'Koperasi Sejahtera',
                'logo' => null,
                'website' => null,
                'description' => 'Kolaborasi penguatan permodalan usaha anggota.',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ]);
    }

    protected function normalizeUrl(?string $url): ?string
    {
        if (! $url) return null;

        return str_starts_with($url, 'http://') || str_starts_with($url, 'https://')
            ? $url
            : 'https://' . $url;
    }

    /* =======================
       PROFIL PENGURUS & PENGAWAS
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
       SETTINGS + GMAPS
    ======================== */
    protected function gmapsEmbedFromUrl(?string $url): ?string
    {
        if (! $url) return null;

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

        return (object)[
            'site_name' => $settings['site_name'] ?? null,
            'address' => $settings['address'] ?? null,
            'phone' => $settings['phone'] ?? null,
            'email' => $settings['email'] ?? null,
            'footer_description' => $settings['footer_description'] ?? null,

            'gmaps_url' => $gmapsUrl,
            'gmaps_embed_src' => $this->gmapsEmbedFromUrl($gmapsUrl),
        ];
    }

    /* =======================
       ABOUT PAGE (Tentang)
    ======================== */
    public function __invoke()
    {
        $about = AboutPage::where('slug', 'tentang-kdmp')->first();

        if (! $about) {
            $about = new AboutPage([
                'profil_singkat' => '',
                'visi' => '',
                'misi' => [],
                'nilai' => [],
            ]);
        }

        return view('public.profil.tentang', compact('about'));
    }
}
