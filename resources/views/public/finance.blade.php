@extends('layouts.public')

@section('P')

<!-- HERO -->
<section class="page-hero">
    <div class="page-hero-inner">
        <h1>Transparansi Keuangan</h1>
        <p>Keterbukaan pengelolaan keuangan Koperasi Desa Merah Putih</p>
    </div>
</section>

<!-- FILTER BULAN + RINGKASAN -->
<section class="container" style="margin-top: 24px;">
    <div class="card">

        <div style="display:flex; justify-content:space-between; align-items:center; gap:16px; flex-wrap:wrap;">
            <h3 style="margin:0;">Ringkasan Bulan</h3>

            <form method="GET" action="{{ url('/transparansi') }}">
                <select name="month" onchange="this.form.submit()"
                        style="padding:10px 12px; border-radius:10px; border:1px solid #e5e5e5;"
                        @disabled(empty($availableMonths) || count($availableMonths) === 0)>
                    @forelse ($availableMonths as $m)
                        <option value="{{ $m }}" @selected($m === $selectedMonth)>
                            {{ $m }}
                        </option>
                    @empty
                        <option value="{{ now()->format('Y-m') }}">
                            {{ now()->format('Y-m') }}
                        </option>
                    @endforelse
                </select>
            </form>
        </div>

        <!-- RINGKASAN -->
        <section class="summary-section" style="padding:18px 0 0;">
            <div class="summary-grid" style="padding:0;">

                <div class="summary-card">
                    <h4>Uang Masuk</h4>
                    <strong>Rp {{ number_format($income ?? 0, 0, ',', '.') }}</strong>
                </div>

                <div class="summary-card">
                    <h4>Uang Keluar</h4>
                    <strong>Rp {{ number_format($expense ?? 0, 0, ',', '.') }}</strong>
                </div>

                <div class="summary-card highlight">
                    <h4>Dari Pendaftar Baru</h4>
                    <strong>Rp {{ number_format($registrationIncome ?? 0, 0, ',', '.') }}</strong>
                </div>

                <div class="summary-card total-akhir">
                    <h4>Total Akhir</h4>
                    <strong>Rp {{ number_format($balance ?? 0, 0, ',', '.') }}</strong>
                </div>

            </div>
        </section>
    </div>
</section>

<!-- GRAFIK -->
<section class="container" style="margin-top: 18px;">
    <div class="card-wrap">
        <h3>Grafik Keuangan (Harian - Bulan)</h3>

        <div class="chart-base">
            <div class="chart-inner">
                <canvas id="financeChart"></canvas>
            </div>
        </div>

        @if (empty($daily) || $daily->count() === 0)
            <p style="margin-top:12px; color:#666;">Belum ada data untuk ditampilkan pada grafik.</p>
        @endif
    </div>
</section>

<!-- TABEL TRANSAKSI PER BULAN -->
<section class="container" style="margin-top: 18px;">
    <div class="card">
        <h3>Daftar Transaksi (Per Bulan)</h3>

        <table class="table">
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Pemasukan</th>
                    <th>Pengeluaran</th>
                    <th>Pendaftar Baru</th>
                    <th>Uang Pendaftaran</th>
                    <th>Saldo Akhir</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($monthly as $row)
                    <tr>
                        <td>{{ $row->month }}</td>
                        <td>Rp {{ number_format($row->income, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($row->expense, 0, ',', '.') }}</td>
                        <td>{{ $row->new_members ?? 0 }} orang</td>
                        <td>Rp {{ number_format($row->registration_income ?? 0, 0, ',', '.') }}</td>
                        <td><strong>Rp {{ number_format($row->balance, 0, ',', '.') }}</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center">
                            Belum ada data transaksi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

{{-- Inject data untuk app.js --}}
<script>
    window.financeDaily = @json($daily ?? []);        // grafik 1 bulan (harian)
    window.financeMonthly = @json($monthly ?? []);    // opsional
    window.selectedMonth = @json($selectedMonth ?? null);
</script>

@endsection
