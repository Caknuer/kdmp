@extends('layouts.public')

@section('P')
    
<h1 class="text-2xl font-bold mb-4">Transparansi Keuangan</h1>

<p>Pemasukan: Rp {{ number_format($summary['income']) }}</p>
<p>Pengeluaran: Rp {{ number_format($summary['expense']) }}</p>

<table class="w-full mt-6">
    <thead>
        <tr class="bg-gray-200">
            <th>Tanggal</th>
            <th>Jenis</th>
            <th>Akun</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $t)
        <tr>
            <td>{{ $t->date }}</td>
            <td>{{ $t->type }}</td>
            <td>{{ $t->account->name }}</td>
            <td>Rp {{ number_format($t->amount) }}</td>
            <td>{{ $t->description }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

    @endsection