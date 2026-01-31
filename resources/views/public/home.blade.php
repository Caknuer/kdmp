@extends('layouts.public')

@section('P')

@include('public.partials.hero')

<!-- RINGKASAN TABUNGAN -->
<section class="summary-section reveal">
    <div class="container summary-grid">

        <div class="summary-card">
            <h4>Total Setoran</h4>
            <strong>
                Rp {{ number_format($summary['credit'] ?? 0, 0, ',', '.') }}
            </strong>
        </div>

        <div class="summary-card">
            <h4>Total Penarikan</h4>
            <strong>
                Rp {{ number_format($summary['debit'] ?? 0, 0, ',', '.') }}
            </strong>
        </div>

        <div class="summary-card total-akhir">
            <h4>Saldo Akhir</h4>
            <strong>
                Rp {{ number_format(($summary['credit'] ?? 0) - ($summary['debit'] ?? 0), 0, ',', '.') }}
            </strong>
        </div>

        <div class="summary-card highlight">
            <h4>Status Program</h4>
            <strong>Tabungan Aktif</strong>
        </div>

    </div>
</section>

@endsection
