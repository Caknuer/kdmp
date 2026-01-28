@extends('layouts.public')

@section('P')

<!-- HERO -->
<section class="page-hero">
    <div class="page-hero-inner">
        <h1>Transparansi Keuangan</h1>
        <p>Keterbukaan pengelolaan keuangan Koperasi Desa Merah Putih</p>
    </div>
</section>

<!-- (OPSIONAL) GRAFIK - kalau nanti mau dipakai -->
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
                    <th>Bulan</th>
                    <th>Pemasukan</th>
                    <th>Pengeluaran</th>
                    <th>Saldo Akhir</th>
                    <th>Pendaftar Baru</th>
                    <th>Uang Pendaftaran</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($monthly as $row)
                    <tr>
                        <td>{{ $row->month }}</td>

                        <td>Rp {{ number_format($row->income, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($row->expense, 0, ',', '.') }}</td>

                        <td><strong>
                            Rp {{ number_format($row->balance, 0, ',', '.') }}
                        </strong></td>

                        <td>{{ $row->new_members ?? 0 }} orang</td>

                        <td>Rp {{ number_format($row->registration_income ?? 0, 0, ',', '.') }}</td>
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

@endsection
