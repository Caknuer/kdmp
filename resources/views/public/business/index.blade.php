@extends('layouts.public')

@section('P')
<section class="page-hero">
    <div class="page-hero-inner">
        <h1>Unit Bisnis KDMP</h1>
        <p>Unit usaha yang dikelola untuk mendukung ekonomi desa</p>
    </div>
</section>

<section class="container">
    <div class="row bisnis-grid">
        @foreach ($units as $unit)
            @php
                // kategori & icon auto (karena DB belum punya kolom itu)
                $n = strtolower($unit->name);
                if (str_contains($n, 'simpan') || str_contains($n, 'pinjam')) { $cat='Keuangan'; $icon='💰'; }
                elseif (str_contains($n, 'dagang') || str_contains($n, 'toko')) { $cat='Perdagangan'; $icon='🛒'; }
                elseif (str_contains($n, 'produksi')) { $cat='Produksi'; $icon='🏭'; }
                elseif (str_contains($n, 'jasa')) { $cat='Jasa'; $icon='🧰'; }
                else { $cat='Unit Usaha'; $icon='🏢'; }
            @endphp

            <a class="bisnis-card"
               href="{{ route('public.business.detail', $unit->slug) }}"
               style="text-decoration:none; color:inherit;">
                <div class="bisnis-icon">{{ $icon }}</div>
                <h4>{{ $unit->name }}</h4>
                <span>{{ $cat }}</span>
            </a>
        @endforeach
    </div>
</section>
@endsection
