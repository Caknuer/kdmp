@extends('layouts.public')

@section('P')

<!-- HERO -->
<section class="page-hero">
  <div class="page-hero-inner">
    <h1>Transparansi Keuangan</h1>
    <p>Keterbukaan pengelolaan keuangan Koperasi Desa Merah Putih untuk kepercayaan dan akuntabilitas</p>
  </div>
</section>

<!-- FILTER BULAN + RINGKASAN -->
<section class="container" style="padding: 60px 0;">
  <div class="finance-header">
    <h2>Ringkasan Keuangan</h2>
    <form method="GET" action="{{ url('/transparansi') }}" class="month-filter">
      <select name="month" onchange="this.form.submit()"
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

  <!-- SUMMARY CARDS -->
  <div class="summary-grid">
    <div class="summary-card">
      <div class="summary-label">Uang Masuk</div>
      <div class="summary-value income">Rp {{ number_format($income ?? 0, 0, ',', '.') }}</div>
      <div class="summary-icon">💰</div>
    </div>

    <div class="summary-card">
      <div class="summary-label">Uang Keluar</div>
      <div class="summary-value expense">Rp {{ number_format($expense ?? 0, 0, ',', '.') }}</div>
      <div class="summary-icon">📤</div>
    </div>

    <div class="summary-card">
      <div class="summary-label">Dari Pendaftar Baru</div>
      <div class="summary-value registration">Rp {{ number_format($registrationIncome ?? 0, 0, ',', '.') }}</div>
      <div class="summary-icon">🆕</div>
    </div>

    <div class="summary-card balance">
      <div class="summary-label">Saldo Akhir</div>
      <div class="summary-value">Rp {{ number_format($balance ?? 0, 0, ',', '.') }}</div>
      <div class="summary-icon">✓</div>
    </div>
  </div>
</section>

<!-- GRAFIK -->
<section class="container" style="padding: 60px 0;">
  <div class="chart-card">
    <h2>Grafik Keuangan (Harian)</h2>
    <p class="chart-subtitle">Trend pemasukan dan pengeluaran selama satu bulan</p>

    <div class="chart-container">
      <canvas id="financeChart"></canvas>
    </div>

    @if (empty($daily) || $daily->count() === 0)
      <div class="empty-state">
        <div class="empty-icon">📊</div>
        <p>Belum ada data grafik untuk ditampilkan pada bulan ini</p>
      </div>
    @endif
  </div>
</section>

<!-- TABEL TRANSAKSI -->
<section class="container" style="padding: 60px 0; margin-bottom: 40px;">
  <div class="table-card">
    <h2>Daftar Transaksi Per Bulan</h2>
    <p class="table-subtitle">Riwayat lengkap transaksi keuangan bulanan</p>

    <div class="table-wrapper">
      <table class="finance-table">
        <thead>
          <tr>
            <th>Periode</th>
            <th class="text-right">Pemasukan</th>
            <th class="text-right">Pengeluaran</th>
            <th class="text-center">Pendaftar Baru</th>
            <th class="text-right">Uang Pendaftaran</th>
            <th class="text-right">Saldo Akhir</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($monthly as $row)
            <tr>
              <td class="period">{{ $row->month }}</td>
              <td class="text-right income-row">Rp {{ number_format($row->income, 0, ',', '.') }}</td>
              <td class="text-right expense-row">Rp {{ number_format($row->expense, 0, ',', '.') }}</td>
              <td class="text-center">{{ $row->new_members ?? 0 }} orang</td>
              <td class="text-right">Rp {{ number_format($row->registration_income ?? 0, 0, ',', '.') }}</td>
              <td class="text-right balance-row"><strong>Rp {{ number_format($row->balance, 0, ',', '.') }}</strong></td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="empty-table">
                <div class="empty-table-state">
                  <div class="empty-icon">📋</div>
                  <p>Belum ada data transaksi</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</section>

{{-- Inject data untuk app.js --}}
<script>
    window.financeDaily = @json($daily ?? []);        // grafik 1 bulan (harian)
    window.financeMonthly = @json($monthly ?? []);    // opsional
    window.selectedMonth = @json($selectedMonth ?? null);
</script>

@endsection
