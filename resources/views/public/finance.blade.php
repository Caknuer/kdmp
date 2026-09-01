@extends('layouts.public')

@section('content')

<!-- HERO SECTION -->
<section class="page-hero page-hero--info">
    <div class="page-hero-inner">
        <span class="hero-pill">💰 Transparansi Keuangan</span>
        <h1>Laporan Keuangan & Akuntabilitas</h1>
        <p>Keterbukaan pengelolaan keuangan Koperasi Desa Merah Putih untuk kepercayaan dan transparansi publik</p>
    </div>
</section>

<!-- FILTER & HEADER -->
<section class="section section--soft">
    <div class="container">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Ringkasan Keuangan</h2>
                <p class="text-gray-600">Laporan terperinci berdasarkan bulan yang dipilih</p>
            </div>
            <form method="GET" action="{{ url('/transparansi') }}" class="flex items-center gap-3">
                <label for="month" class="text-sm font-semibold text-gray-700">Pilih Bulan:</label>
                <select id="month" name="month" onchange="this.form.submit()"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"
                        @disabled(empty($availableMonths) || count($availableMonths) === 0)>
                    @forelse ($availableMonths as $m)
                        <option value="{{ $m }}" @selected($m === $selectedMonth)>
                            {{ date('F Y', strtotime($m . '-01')) }}
                        </option>
                    @empty
                        <option value="{{ now()->format('Y-m') }}">
                            {{ now()->format('F Y') }}
                        </option>
                    @endforelse
                </select>
            </form>
        </div>

        <!-- SUMMARY CARDS (Stat Cards Style) -->
        <div class="stat-grid">
            <article class="stat-card stat-card--primary">
                <span class="stat-label">💰 Uang Masuk</span>
                <strong class="stat-value">Rp {{ number_format($income ?? 0, 0, ',', '.') }}</strong>
                <small class="stat-note">Total pemasukan bulan ini</small>
            </article>

            <article class="stat-card stat-card--accent">
                <span class="stat-label">📤 Uang Keluar</span>
                <strong class="stat-value">Rp {{ number_format($expense ?? 0, 0, ',', '.') }}</strong>
                <small class="stat-note">Total pengeluaran bulan ini</small>
            </article>

            <article class="stat-card stat-card--dark">
                <span class="stat-label">✓ Saldo Akhir</span>
                <strong class="stat-value">Rp {{ number_format($balance ?? 0, 0, ',', '.') }}</strong>
                <small class="stat-note">Aset kas bersih saat ini</small>
            </article>

            <article class="stat-card stat-card--muted">
                <span class="stat-label">🆕 Pendaftaran Baru</span>
                <strong class="stat-value">Rp {{ number_format($registrationIncome ?? 0, 0, ',', '.') }}</strong>
                <small class="stat-note">Dari anggota baru bulan ini</small>
            </article>
        </div>
    </div>
</section>

<!-- GRAFIK SECTION -->
<section class="section section--soft">
    <div class="container">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden p-8">
            <div class="mb-6">
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-2xl">📊</span>
                    <div>
                        <h3 class="text-xl md:text-2xl font-bold text-gray-900">Grafik Keuangan Harian</h3>
                        <p class="text-sm text-gray-600">Trend pemasukan dan pengeluaran harian dalam {{ date('F Y', strtotime($selectedMonth . '-01')) }}</p>
                    </div>
                </div>
            </div>

            @if (!empty($daily) && $daily->count() > 0)
                <div class="chart-container" style="position: relative; height: 400px; margin-bottom: 20px;">
                    <canvas id="financeChart"></canvas>
                </div>

                <!-- Chart Legend -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-6 pt-6 border-t border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-4 h-4 rounded bg-green-500"></div>
                        <span class="text-sm text-gray-600">Pemasukan</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-4 h-4 rounded bg-red-500"></div>
                        <span class="text-sm text-gray-600">Pengeluaran</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-4 h-4 rounded bg-blue-500"></div>
                        <span class="text-sm text-gray-600">Saldo Bersih</span>
                    </div>
                </div>
            @else
                <div class="py-12 text-center">
                    <div class="text-5xl mb-4">📊</div>
                    <p class="text-gray-600">Belum ada data grafik untuk ditampilkan pada bulan {{ date('F Y', strtotime($selectedMonth . '-01')) }}</p>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- TABEL TRANSAKSI BULANAN -->
<section class="section section--soft">
    <div class="container">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header -->
            <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-2xl">📋</span>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900">Daftar Transaksi Bulanan</h3>
                </div>
                <p class="text-sm text-gray-600">Riwayat lengkap transaksi keuangan bulanan dari awal hingga sekarang</p>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold text-gray-700">Periode</th>
                            <th class="px-6 py-4 text-right font-semibold text-gray-700">
                                <span class="inline-flex items-center gap-1">
                                    <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                                    Pemasukan
                                </span>
                            </th>
                            <th class="px-6 py-4 text-right font-semibold text-gray-700">
                                <span class="inline-flex items-center gap-1">
                                    <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                                    Pengeluaran
                                </span>
                            </th>
                            <th class="px-6 py-4 text-center font-semibold text-gray-700">Pendaftar Baru</th>
                            <th class="px-6 py-4 text-right font-semibold text-gray-700">Uang Pendaftaran</th>
                            <th class="px-6 py-4 text-right font-semibold text-gray-700">Saldo Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($monthly as $row)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ date('F Y', strtotime($row->month . '-01')) }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-green-50 text-green-700 font-semibold text-sm">
                                        Rp {{ number_format($row->income, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-red-50 text-red-700 font-semibold text-sm">
                                        Rp {{ number_format($row->expense, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-blue-50 text-blue-700 font-semibold text-sm">
                                        {{ $row->new_members ?? 0 }} <span class="text-xs ml-1">orang</span>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right font-medium text-gray-900">
                                    Rp {{ number_format($row->registration_income ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-indigo-50 text-indigo-700 font-bold">
                                        Rp {{ number_format($row->balance, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="text-5xl mb-3">📋</div>
                                    <p class="text-gray-600 font-medium">Belum ada data transaksi</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- INFO SECTION -->
<section class="section section--soft">
    <div class="container">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200 p-8">
            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <span class="text-4xl">ℹ️</span>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Tentang Transparansi Keuangan</h3>
                    <ul class="space-y-2 text-gray-700 text-sm">
                        <li><strong>📊 Grafik Harian:</strong> Menampilkan tren pemasukan, pengeluaran, dan saldo bersih setiap hari dalam bulan yang dipilih.</li>
                        <li><strong>📋 Tabel Bulanan:</strong> Ringkasan lengkap transaksi per bulan untuk transparansi akuntabilitas koperasi.</li>
                        <li><strong>👥 Pendaftar Baru:</strong> Jumlah dan nilai uang pendaftaran dari anggota baru setiap bulannya.</li>
                        <li><strong>✓ Saldo Akhir:</strong> Posisi kas koperasi pada akhir periode yang ditampilkan untuk kepercayaan publik.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@push('head-scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

<!-- Chart.js Initialization -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const financeDaily = @json($daily ?? []);
        
        if (financeDaily && financeDaily.length > 0) {
            const dates = financeDaily.map(item => item.day);
            const incomes = financeDaily.map(item => item.income || 0);
            const expenses = financeDaily.map(item => item.expense || 0);
            
            // Calculate running balance
            let runningBalance = 0;
            const balances = financeDaily.map(item => {
                runningBalance += (item.income || 0) - (item.expense || 0);
                return runningBalance;
            });

            const ctx = document.getElementById('financeChart')?.getContext('2d');
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dates,
                        datasets: [
                            {
                                label: 'Pemasukan',
                                data: incomes,
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointBackgroundColor: '#10b981',
                                pointBorderColor: '#ffffff',
                                pointBorderWidth: 2,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Pengeluaran',
                                data: expenses,
                                borderColor: '#ef4444',
                                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointBackgroundColor: '#ef4444',
                                pointBorderColor: '#ffffff',
                                pointBorderWidth: 2,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Saldo Bersih',
                                data: balances,
                                borderColor: '#3b82f6',
                                backgroundColor: 'rgba(59, 130, 246, 0.05)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4,
                                borderDash: [5, 5],
                                pointRadius: 3,
                                pointBackgroundColor: '#3b82f6',
                                pointBorderColor: '#ffffff',
                                pointBorderWidth: 1,
                                yAxisID: 'y1'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    font: { size: 12, weight: '600' },
                                    padding: 15,
                                    usePointStyle: true
                                }
                            },
                            filler: {
                                propagate: true
                            }
                        },
                        scales: {
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Pemasukan & Pengeluaran (Rp)',
                                    font: { weight: 'bold' }
                                },
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                }
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                title: {
                                    display: true,
                                    text: 'Saldo Bersih (Rp)',
                                    font: { weight: 'bold' }
                                },
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                },
                                grid: {
                                    drawOnChartArea: false
                                }
                            }
                        }
                    }
                });
            }
        }
    });
</script>

@endsection
