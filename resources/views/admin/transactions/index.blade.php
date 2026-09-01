@extends('admin.layouts.app')

@section('title', 'Daftar Transaksi')
@section('page_title', 'Manajemen Transaksi')
@section('page_subtitle', 'Kelola pemasukan dan pengeluaran')

@section('content')
<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="bg-green-50 border border-green-200 rounded-lg p-6">
        <p class="text-sm font-semibold text-green-700">Total Pemasukan</p>
        <p class="text-3xl font-bold text-green-900 mt-2">Rp {{ number_format($income_total) }}</p>
    </div>
    <div class="bg-red-50 border border-red-200 rounded-lg p-6">
        <p class="text-sm font-semibold text-red-700">Total Pengeluaran</p>
        <p class="text-3xl font-bold text-red-900 mt-2">Rp {{ number_format($expense_total) }}</p>
    </div>
</div>

<!-- Filter & Search -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form action="{{ route('admin.transactions.index') }}" method="GET" class="grid grid-cols-1 lg:grid-cols-6 gap-3 items-end">
        <div class="lg:col-span-2">
            <label class="block text-xs font-semibold text-gray-600 mb-2">Cari</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari keterangan..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-2">Jenis</label>
            <select name="transaction_for" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                <option value="all">Semua Jenis</option>
                <option value="member" {{ request('transaction_for') == 'member' ? 'selected' : '' }}>Transaksi Anggota</option>
                <option value="cash" {{ request('transaction_for') == 'cash' ? 'selected' : '' }}>Kas Masuk/Keluar</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-2">Sumber</label>
            <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                <option value="all">Semua Sumber</option>
                @foreach($sourceOptions as $key => $label)
                    <option value="{{ $key }}" {{ request('category') === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
                @foreach($customCategories as $custom)
                    <option value="{{ $custom }}" {{ request('category') === $custom ? 'selected' : '' }}>{{ ucfirst(str_replace(['_', '-'], [' ', ' '], $custom)) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-2">Tipe</label>
            <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                <option value="all">Semua Tipe</option>
                <option value="credit" {{ request('type') == 'credit' ? 'selected' : '' }}>Pemasukan</option>
                <option value="debit" {{ request('type') == 'debit' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-2">Bulan</label>
            <select name="month" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                <option value="">Semua Bulan</option>
                @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                </option>
                @endfor
            </select>
        </div>
        <div class="flex items-center">
            <button type="submit" class="w-full px-6 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg transition">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jenis</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Anggota</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Sumber</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Keterangan</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tipe</th>
                <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Jumlah</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($transactions as $transaction)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm text-gray-600">{{ $transaction->date->format('d M Y') }}</td>
                <td class="px-6 py-4 text-sm">
                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $transaction->transaction_for == 'member' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                        {{ $transaction->transaction_for == 'member' ? 'Anggota' : 'Kas' }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">{{ $transaction->member->name ?? '-' }}</td>
                <td class="px-6 py-4 text-sm text-gray-700">{{ $transaction->category_label }}</td>
                <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ $transaction->description }}</td>
                <td class="px-6 py-4 text-sm">
                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $transaction->type == 'credit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $transaction->type == 'credit' ? 'Pemasukan' : 'Pengeluaran' }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm font-bold text-right {{ $transaction->type == 'credit' ? 'text-green-600' : 'text-red-600' }}">
                    {{ $transaction->type == 'credit' ? '+' : '-' }} Rp {{ number_format($transaction->amount) }}
                </td>
                <td class="px-6 py-4 text-sm">
                    <a href="{{ route('admin.transactions.edit', $transaction) }}" class="px-3 py-1 bg-yellow-50 text-yellow-600 hover:bg-yellow-100 rounded text-xs font-semibold">Edit</a>
                    <form action="{{ route('admin.transactions.destroy', $transaction) }}" method="POST" onsubmit="return confirm('Yakin?')" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-red-50 text-red-600 hover:bg-red-100 rounded text-xs font-semibold">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="px-6 py-8 text-center text-gray-500">Tidak ada transaksi</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t flex items-center justify-between">
        <a href="{{ route('admin.transactions.create') }}" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
            <i class="fas fa-plus mr-2"></i> Transaksi Baru
        </a>
        {{ $transactions->links() }}
    </div>
</div>
@endsection
