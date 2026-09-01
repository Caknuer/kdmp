@extends('layouts.public')

@section('content')
@php
    $categoryFallback = function (?string $name): string {
        $n = strtolower($name ?? '');
        if (str_contains($n, 'simpan') || str_contains($n, 'pinjam') || str_contains($n, 'keuangan')) return 'Keuangan';
        if (str_contains($n, 'dagang') || str_contains($n, 'toko') || str_contains($n, 'perdagangan') || str_contains($n, 'minimarket')) return 'Perdagangan';
        if (str_contains($n, 'produksi') || str_contains($n, 'olah')) return 'Produksi';
        if (str_contains($n, 'jasa')) return 'Jasa';
        return 'Lainnya';
    };

    $iconFallback = function (string $category): string {
        return match ($category) {
            'Keuangan' => 'money-bill-wave',
            'Perdagangan' => 'store',
            'Produksi' => 'seedling',
            'Jasa' => 'handshake',
            default => 'building',
        };
    };
@endphp

<section class="page-hero">
    <div class="page-hero-inner">
        <h1>Unit Bisnis KDMP</h1>
        <p>Unit usaha yang dikelola untuk mendukung ekonomi warga dan desa Wonokerto</p>
    </div>
</section>

@if (!empty($isDummy))
    <section class="container">
        <div class="dummy-note bisnis-dummy-note">
            <strong>Data contoh aktif:</strong> daftar unit usaha saat ini masih menggunakan data dummy. Lengkapi data unit di admin panel untuk menampilkan informasi nyata.
        </div>
    </section>
@endif

<section class="container">
    <div class="bisnis-grid">
        @forelse ($units as $unit)
            @php
                $cat = $unit->category ?: $categoryFallback($unit->name);
                $iconName = $unit->icon ? str_replace('fa-', '', $unit->icon) : $iconFallback($cat);
                $thumbUrl = $unit->thumbnail_url ?? (!empty($unit->thumbnail) ? Storage::disk('public')->url($unit->thumbnail) : null);
                $desc = $unit->description ?: 'Deskripsi unit usaha belum tersedia.';
            @endphp

            <a class="bisnis-card" href="{{ route('public.business.detail', $unit->slug) }}">
                <div class="bisnis-head">
                    @if ($thumbUrl)
                        <div class="bisnis-logo">
                            <img src="{{ $thumbUrl }}" alt="{{ $unit->name }}" onerror="this.parentElement.style.display='none'; this.parentElement.nextElementSibling.style.display='grid';">
                        </div>
                        <div class="bisnis-icon" aria-hidden="true" style="display:none; place-items:center; color:#0f172a; font-size:1.75rem;">
                            <i class="fas fa-{{ $iconName }}"></i>
                        </div>
                    @else
                        <div class="bisnis-icon" aria-hidden="true" style="display:grid; place-items:center; color:#0f172a; font-size:1.75rem;">
                            <i class="fas fa-{{ $iconName }}"></i>
                        </div>
                    @endif

                    <div class="bisnis-meta">
                        <h4>{{ $unit->name }}</h4>
                        <span class="bisnis-chip">{{ $cat }}</span>
                    </div>
                </div>

                <div class="bisnis-desc">
                    {{ Str::limit($desc, 120) }}
                </div>
            </a>
        @empty
            <div class="bisnis-empty">
                <h3 style="margin:0 0 8px; font-weight:900; color:#0f172a;">Belum ada unit usaha</h3>
                <p>Silakan tambahkan data unit usaha dari admin panel.</p>
            </div>
        @endforelse
    </div>
</section>
@endsection
