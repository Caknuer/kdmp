<?php

namespace App\Http\Controllers;

use App\Models\AboutPage;
use App\Models\Article;
use App\Models\BusinessUnit;
use App\Models\Partner;
use App\Models\Transaction;
use App\Models\Setting;
use App\Models\OrganizationMember;
use App\Models\FinanceTransaction;
use App\Models\Member;
use Illuminate\Support\Facades\Schema;

class PublicController extends Controller
{
    /* =======================
       BERANDA
    ======================== */
    public function home()
    {
        // ambil bulan berjalan (untuk ringkasan home)
        $selectedMonth = now()->format('Y-m');
        $startDate = "{$selectedMonth}-01";
        $endDate   = date('Y-m-t', strtotime($startDate));

        // A. finance_transactions
        $financeIncome = FinanceTransaction::whereBetween('date', [$startDate, $endDate])
            ->where('type', 'income')
            ->sum('amount');

        $financeExpense = FinanceTransaction::whereBetween('date', [$startDate, $endDate])
            ->where('type', 'expense')
            ->sum('amount');

        // B. transactions (member)
        $memberIncome = Transaction::whereBetween('date', [$startDate, $endDate])
            ->where('type', 'credit')
            ->sum('amount');

        $memberExpense = Transaction::whereBetween('date', [$startDate, $endDate])
            ->where('type', 'debit')
            ->sum('amount');

        // TOTAL gabungan
        $income  = $financeIncome + $memberIncome;
        $expense = $financeExpense + $memberExpense;
        $balance = $income - $expense;

        // pendaftar baru (initial)
        $registrationIncome = Transaction::whereBetween('date', [$startDate, $endDate])
            ->where('type', 'credit')
            ->where('category', 'initial')
            ->sum('amount');

        // Statistik Anggota Koperasi (Aman jika kolom role/status belum ada di DB)
        $hasMembersTable = Schema::hasTable('members');
        $hasRole = $hasMembersTable && Schema::hasColumn('members', 'role');
        $hasStatus = $hasMembersTable && Schema::hasColumn('members', 'status');
        $hasRegisteredAt = $hasMembersTable && Schema::hasColumn('members', 'registered_at');

        $totalMembers = $hasMembersTable ? Member::count() : 0;
        $activeMembers = $hasStatus ? Member::where('status', 'approved')->count() : $totalMembers;
        $pendingMembers = $hasStatus ? Member::where('status', 'pending')->count() : 0;
        $platinumMembers = $hasRole ? Member::where('role', 'platinum')->count() : 0;
        $premiumMembers = $hasRole ? Member::where('role', 'premium')->count() : 0;

        $memberStats = [
            'total' => $totalMembers,
            'active' => $activeMembers,
            'pending' => $pendingMembers,
            'platinum' => $platinumMembers,
            'premium' => $premiumMembers,
        ];

        // Statistik Mitra & Unit Usaha
        $partnerCount = Partner::count();
        $businessUnitCount = BusinessUnit::count();

        // Daftar Anggota Terbaru (untuk transparansi jumlah terdaftar)
        $recentMembersQuery = Member::query();
        if ($hasRegisteredAt) {
            $recentMembersQuery->orderBy('registered_at', 'desc');
        }
        $recentMembers = $hasMembersTable ? $recentMembersQuery->orderBy('id', 'desc')->take(8)->get() : collect();

        return view('public.home', [
            'pageTitle' => 'Beranda',

            'pageDescription' => 'Koperasi Desa Merah Putih Wonokerto - Mengelola potensi desa secara transparan dan profesional.',

            'latestInfo' => Article::published()
                ->latest('published_at')
                ->limit(6)
                ->get(),

            // ringkasan keuangan untuk home
            'summary' => [
                'month' => $selectedMonth,
                'income' => $income,
                'expense' => $expense,
                'registration_income' => $registrationIncome,
                'balance' => $balance,
            ],

            'memberStats' => $memberStats,
            'partnerCount' => $partnerCount,
            'businessUnitCount' => $businessUnitCount,
            'recentMembers' => $recentMembers,

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
            ->get();

        $isDummy = false;

        if ($units->isEmpty()) {
            $units = $this->dummyBusinessUnits();
            $isDummy = true;
        }

        return view('public.business.index', [
            'pageTitle' => 'Unit Bisnis',
            'pageDescription' => 'Daftar unit bisnis KDMP Wonokerto yang mendukung perekonomian desa.',
            'units' => $units,
            'isDummy' => $isDummy,
            'setting' => $this->getSettings(),
        ]);
    }

    public function businessDetail(string $slug)
    {
        $unit = BusinessUnit::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();

        $isDummy = false;

        if (! $unit) {
            $unit = $this->findDummyBusinessUnitBySlug($slug);
            abort_if(! $unit, 404);
            $isDummy = true;
        }

        return view('public.business.detail', [
            'pageTitle' => $unit->name,
            'pageDescription' => $unit->description ? strip_tags($unit->description) : 'Detail unit bisnis ' . $unit->name,
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
                'thumbnail_url' => null,
                'description' => "Melayani simpan pinjam anggota dengan prinsip koperasi.\nProses transparan dan pelayanan cepat.",
                'category' => 'Keuangan',
                'icon' => 'money-bill-wave',
                'services' => "Simpanan Wajib & Sukarela\nPinjaman Modal Usaha\nTabungan Masa Depan",
                'is_active' => true,
                'order' => 1,
            ],
            (object)[
                'id' => null,
                'name' => 'Unit Perdagangan',
                'slug' => 'unit-perdagangan',
                'thumbnail' => null,
                'thumbnail_url' => null,
                'description' => "Mengelola penjualan kebutuhan masyarakat dan pemasaran produk UMKM desa.",
                'category' => 'Perdagangan',
                'icon' => 'store',
                'services' => "Toko Sembako Murah\nPemasaran Produk UMKM\nPenyaluran Pupuk & Sarana Pertanian",
                'is_active' => true,
                'order' => 2,
            ],
            (object)[
                'id' => null,
                'name' => 'Unit Produksi',
                'slug' => 'unit-produksi',
                'thumbnail' => null,
                'thumbnail_url' => null,
                'description' => "Mengolah potensi desa menjadi produk bernilai tambah.",
                'category' => 'Produksi',
                'icon' => 'seedling',
                'services' => "Pengolahan Hasil Pertanian\nProduksi Pangan Lokal\nPengemasan & Standardisasi",
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
    ======================== */
    public function partners()
    {
        $partners = Partner::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->map(function ($p) {
                $p->website = $this->normalizeUrl($p->website);
                return $p;
            });

        return view('public.partners', [
            'pageTitle' => 'Mitra Kami',
            'pageDescription' => 'Daftar mitra dan kolaborator KDMP Wonokerto.',
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
            'pageTitle' => 'Pengurus',
            'pageDescription' => 'Daftar pengurus KDMP Wonokerto.',
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
            'pageTitle' => 'Pengawas',
            'pageDescription' => 'Daftar pengawas KDMP Wonokerto.',
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
    public function tentang()
    {
        $about = AboutPage::first(); // ← juga perlu diperbaiki, lihat poin 2

        if (! $about) {
            $about = new AboutPage([
                'profil_singkat' => '',
                'visi' => '',
                'misi' => [],
                'nilai' => [],
            ]);
        }
        
        return view('public.profil.tentang', [
            'pageTitle' => 'Tentang Kami',
            'pageDescription' => 'Profil, visi, misi, dan nilai-nilai KDMP Wonokerto.',
            'about' => $about,
            'setting' => $this->getSettings(),
        ]);
    }
}
