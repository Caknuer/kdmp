@extends('admin.layouts.app')

@section('title', 'Detail Transaksi')
@section('page_title', 'Detail Transaksi')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
    <div class="space-y-4 mb-8">
        <div class="flex justify-between items-start pb-4 border-b">
            <div>
                <p class="text-gray-600 text-sm">Keterangan</p>
                <p class="text-2xl font-bold text-gray-800">{{ $transaction->description }}</p>
            </div>
            <span class="px-3 py-1 rounded text-sm font-semibold {{ $transaction->type == 'credit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $transaction->type == 'credit' ? 'Pemasukan' : 'Pengeluaran' }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 text-sm">Tanggal</p>
                <p class="font-semibold text-gray-800">{{ $transaction->date->format('d F Y') }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Jumlah</p>
                <p class="text-2xl font-bold {{ $transaction->type == 'credit' ? 'text-green-600' : 'text-red-600' }}">
                    Rp {{ number_format($transaction->amount) }}
                </p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Anggota</p>
                <p class="font-semibold text-gray-800">{{ $transaction->member->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Sumber / Kategori</p>
                <p class="font-semibold text-gray-800">{{ $transaction->category ? ucfirst($transaction->category) : '-' }}</p>
            </div>
        </div>
    </div>

    <div class="flex gap-3 pt-6 border-t">
        <a href="{{ route('admin.transactions.edit', $transaction) }}" class="px-6 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition">
            <i class="fas fa-edit mr-2"></i> Edit
        </a>
        <form action="{{ route('admin.transactions.destroy', $transaction) }}" method="POST" onsubmit="return confirm('Yakin?')" class="inline">
            @csrf @method('DELETE')
            <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                <i class="fas fa-trash mr-2"></i> Hapus
            </button>
        </form>
        <a href="{{ route('admin.transactions.index') }}" class="px-6 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg transition">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>
</div>
@endsection
