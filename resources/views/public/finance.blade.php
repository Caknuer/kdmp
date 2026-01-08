@extends('layouts.public')

@section('P')
    
<!-- HERO -->
<section class="page-hero">
    <div class="page-hero-inner">
        <h1>Transparansi Keuangan</h1>
        <p>Keterbukaan pengelolaan keuangan Koperasi Desa Merah Putih</p>
    </div>
</section>

<!-- RINGKASAN -->
<section class="container">
    <div class="row">

        <div class="card">
            <h3>Total Pemasukan</h3>
            <div class="amount">
                Rp {{ number_format($summary['income'],0,',','.') }}
            </div>
        </div>

        <div class="card">
            <h3>Total Pengeluaran</h3>
            <div class="amount">
                Rp {{ number_format($summary['expense'],0,',','.') }}
            </div>
        </div>

    </div>
</section>

<!-- GRAFIK -->
<section class="container">
    <div class="card">
        <h3>Grafik Keuangan</h3>
        <canvas id="financeChart" height="120"></canvas>
    </div>
</section>

<!-- TABEL TRANSAKSI -->
<section class="container">
    <div class="card">
        <h3>Daftar Transaksi</h3>

        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $trx)
                    <tr>
                        <td>{{ $trx->created_at->format('d M Y') }}</td>
                        <td>{{ $trx->description ?? '-' }}</td>
                        <td>
                            {{ ucfirst($trx->type) }}
                        </td>
                        <td>
                            Rp {{ number_format($trx->amount,0,',','.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center">
                            Belum ada data transaksi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:20px">
            {{ $transactions->links() }}
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('financeChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Pemasukan', 'Pengeluaran'],
        datasets: [{
            label: 'Jumlah (Rp)',
            data: [
                {{ $summary['income'] }},
                {{ $summary['expense'] }}
            ],
            backgroundColor: ['#16a34a', '#dc2626'],
            borderRadius: 8
        }]
    },
    options: {
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

    @endsection