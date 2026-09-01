@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Selamat datang di admin panel KDMP Wonokerto')

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Pengurus -->
    <a href="{{ route('admin.pengurus.index') }}" class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Pengurus KDMP</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_pengurus'] ?? 0 }}</p>
                <p class="text-xs text-green-600 mt-1">{{ $stats['active_pengurus'] ?? 0 }} aktif</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-blue-100 group-hover:bg-blue-200 flex items-center justify-center transition">
                <i class="fas fa-user-tie text-2xl text-blue-600"></i>
            </div>
        </div>
    </a>

    <!-- Pengawas -->
    <a href="{{ route('admin.pengawas.index') }}" class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500 hover:shadow-lg transition group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Pengawas KDMP</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_pengawas'] ?? 0 }}</p>
                <p class="text-xs text-green-600 mt-1">{{ $stats['active_pengawas'] ?? 0 }} aktif</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-purple-100 group-hover:bg-purple-200 flex items-center justify-center transition">
                <i class="fas fa-user-shield text-2xl text-purple-600"></i>
            </div>
        </div>
    </a>

    <!-- Anggota Koperasi -->
    <a href="{{ route('admin.members.index') }}" class="bg-white rounded-lg shadow-md p-6 border-l-4 border-amber-500 hover:shadow-lg transition group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Anggota Koperasi</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_members'] }}</p>
                <p class="text-xs text-green-600 mt-1">{{ $stats['active_members'] }} terverifikasi</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-amber-100 group-hover:bg-amber-200 flex items-center justify-center transition">
                <i class="fas fa-users text-2xl text-amber-600"></i>
            </div>
        </div>
    </a>

    <!-- Total Articles -->
    <a href="{{ route('admin.articles.index') }}" class="bg-white rounded-lg shadow-md p-6 border-l-4 border-rose-500 hover:shadow-lg transition group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Total Informasi</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_articles'] }}</p>
                <p class="text-xs text-green-600 mt-1">{{ $stats['published_articles'] }} dipublikasi</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-rose-100 group-hover:bg-rose-200 flex items-center justify-center transition">
                <i class="fas fa-newspaper text-2xl text-rose-600"></i>
            </div>
        </div>
    </a>
</div>

<!-- Finance Summary & Quick Actions -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Income/Expense -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-chart-pie mr-2 text-rose-600"></i> Ringkasan Keuangan
            </h3>
            <a href="{{ route('admin.transactions.index') }}" class="text-rose-600 hover:text-rose-700 text-xs font-semibold">
                Lihat Transaksi →
            </a>
        </div>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                <span class="text-green-700 font-semibold">Pemasukan:</span>
                <span class="text-green-600 font-bold">Rp {{ number_format($stats['total_income']) }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                <span class="text-red-700 font-semibold">Pengeluaran:</span>
                <span class="text-red-600 font-bold">Rp {{ number_format($stats['total_expense']) }}</span>
            </div>
            <div class="h-px bg-gray-200"></div>
            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                <span class="text-blue-700 font-semibold">Saldo:</span>
                <span class="text-blue-600 font-bold">Rp {{ number_format($stats['balance']) }}</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">
            <i class="fas fa-bolt mr-2 text-yellow-600"></i> Aksi Cepat
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <a href="{{ route('admin.pengurus.create') }}" 
               class="p-3 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-user-plus text-blue-600"></i>
                <span class="text-sm font-semibold">Tambah Pengurus</span>
            </a>
            <a href="{{ route('admin.pengawas.create') }}" 
               class="p-3 bg-purple-50 hover:bg-purple-100 text-purple-700 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-user-shield text-purple-600"></i>
                <span class="text-sm font-semibold">Tambah Pengawas</span>
            </a>
            <a href="{{ route('admin.articles.create') }}" 
               class="p-3 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-pen-fancy text-rose-600"></i>
                <span class="text-sm font-semibold">Buat Informasi</span>
            </a>
            <a href="{{ route('admin.transactions.create') }}" 
               class="p-3 bg-green-50 hover:bg-green-100 text-green-700 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-money-bill-wave text-green-600"></i>
                <span class="text-sm font-semibold">Catat Transaksi</span>
            </a>
        </div>
    </div>
</div>

<!-- Recent Data -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Articles -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-newspaper mr-2 text-purple-600"></i> Informasi Terbaru
            </h3>
            <a href="{{ route('admin.articles.index') }}" class="text-rose-600 hover:text-rose-700 text-sm font-semibold">
                Lihat Semua →
            </a>
        </div>
        <div class="space-y-3">
            @forelse($recent_articles as $article)
            <div class="p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800">{{ $article->title }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $article->created_at->diffForHumans() }} • 
                            <span class="inline-block px-2 py-1 rounded text-white text-xs {{ $article->is_published ? 'bg-green-600' : 'bg-gray-600' }}">
                                {{ $article->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-gray-500 text-sm text-center py-4">Belum ada informasi</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-exchange-alt mr-2 text-green-600"></i> Transaksi Terbaru
            </h3>
            <a href="{{ route('admin.transactions.index') }}" class="text-rose-600 hover:text-rose-700 text-sm font-semibold">
                Lihat Semua →
            </a>
        </div>
        <div class="space-y-3">
            @forelse($recent_transactions as $transaction)
            <div class="p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800">{{ $transaction->description }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $transaction->date->format('d M Y') }}</p>
                    </div>
                    <p class="font-bold {{ $transaction->type === 'credit' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $transaction->type === 'credit' ? '+' : '-' }} Rp {{ number_format($transaction->amount) }}
                    </p>
                </div>
            </div>
            @empty
            <p class="text-gray-500 text-sm text-center py-4">Belum ada transaksi</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
