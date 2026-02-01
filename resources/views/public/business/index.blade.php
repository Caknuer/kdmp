@extends('layouts.public')

@section('P')
@php
    /**
     * Fallback map jika data belum lengkap
     * Icon disimpan sebagai string (Heroicons) untuk aman saat deploy.
     */
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
            'Keuangan' => 'heroicon-o-banknotes',
            'Perdagangan' => 'heroicon-o-shopping-cart',
            'Produksi' => 'heroicon-o-cog-6-tooth',
            'Jasa' => 'heroicon-o-briefcase',
            default => 'heroicon-o-building-storefront',
        };
    };
@endphp

<section class="page-hero">
    <div class="page-hero-inner">
        <h1>Unit Bisnis KDMP</h1>
        <p>Unit usaha yang dikelola untuk mendukung ekonomi desa</p>
    </div>
</section>

<section class="container">
    <div class="bisnis-grid">

        @forelse ($units as $unit)
            @php
                // Ambil dari DB, kalau kosong pakai fallback
                $cat  = $unit->category ?: $categoryFallback($unit->name);
                $icon = $unit->icon ?: $iconFallback($cat);

                // Thumbnail public
                $thumbUrl = !empty($unit->thumbnail)
                    ? Storage::disk('public')->url($unit->thumbnail)
                    : null;

                // Deskripsi ringkas
                $desc = $unit->description ?: 'Deskripsi unit usaha belum tersedia.';
            @endphp

            <a class="bisnis-card" href="{{ route('public.business.detail', $unit->slug) }}">
                <div class="bisnis-head">

                    {{-- Thumbnail jika ada --}}
                    @if ($thumbUrl)
                        <div class="bisnis-logo">
                            <img src="{{ $thumbUrl }}" alt="{{ $unit->name }}">
                        </div>
                    @else
                        {{-- Jika tidak ada thumbnail, tampilkan icon dari DB (Heroicon) --}}
                        <div class="bisnis-icon" aria-hidden="true" style="display:grid; place-items:center;">
                            <x-dynamic-component :component="$icon" class="w-8 h-8" />
                        </div>
                    @endif

                    <div class="bisnis-meta">
                        <h4>{{ $unit->name }}</h4>
                        <span class="bisnis-chip">{{ $cat }}</span>
                    </div>
                </div>

                <div class="bisnis-desc">
                    {{ $desc }}
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
