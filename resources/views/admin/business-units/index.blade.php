@extends('admin.layouts.app')

@section('title', 'Kelola Unit Bisnis')
@section('page_title', 'Kelola Unit Bisnis')
@section('page_subtitle', 'Daftar dan kelola semua unit usaha dan bisnis koperasi KDMP')

@section('content')
<!-- Top Stat Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Unit Bisnis</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalUnits }}</p>
        </div>
        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
            <i class="fas fa-building"></i>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Unit Aktif</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $activeUnits }}</p>
        </div>
        <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-xl">
            <i class="fas fa-check-circle"></i>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</p>
            <p class="text-2xl font-bold text-purple-600 mt-1">{{ count($categories) }}</p>
        </div>
        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
            <i class="fas fa-tags"></i>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Halaman Publik</p>
            <a href="{{ url('/unit-bisnis') }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-semibold text-rose-600 hover:text-rose-700 mt-2">
                Lihat di Web <i class="fas fa-external-link-alt text-xs"></i>
            </a>
        </div>
        <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl">
            <i class="fas fa-globe"></i>
        </div>
    </div>
</div>

<!-- Header with Search & Filters -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 mb-6">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <!-- Form Pencarian & Filter -->
        <form action="{{ route('admin.business-units.index') }}" method="GET" class="flex flex-wrap items-center gap-3 flex-1">
            <div class="relative flex-1 min-w-[240px]">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text"
                       name="search"
                       value="{{ $search }}"
                       placeholder="Cari nama, layanan, atau deskripsi..."
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500">
            </div>

            <!-- Filter Status -->
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500">
                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Semua Status</option>
                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>

            <!-- Filter Kategori -->
            <select name="category" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500">
                <option value="all" {{ $category === 'all' ? 'selected' : '' }}>Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ $category === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>

            <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white rounded-lg text-sm font-medium transition flex items-center gap-2">
                <i class="fas fa-filter text-xs"></i> Filter
            </button>

            @if($search || ($status && $status !== 'all') || ($category && $category !== 'all'))
                <a href="{{ route('admin.business-units.index') }}" class="text-sm text-gray-500 hover:text-gray-700 underline">
                    Reset
                </a>
            @endif
        </form>

        <!-- Tambah Button -->
        <a href="{{ route('admin.business-units.create') }}"
           class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-semibold transition flex items-center justify-center gap-2 shadow-sm whitespace-nowrap">
            <i class="fas fa-plus"></i> Tambah Unit Bisnis
        </a>
    </div>
</div>

<!-- Business Units Table Container -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-700 uppercase font-semibold text-xs">
                <tr>
                    <th class="px-6 py-4 w-16 text-center">Urutan</th>
                    <th class="px-6 py-4 w-20">Thumbnail</th>
                    <th class="px-6 py-4">Nama Unit & Slug</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Layanan / Jasa</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center w-36">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($businessUnits as $businessUnit)
                <tr class="hover:bg-gray-50/80 transition">
                    <td class="px-6 py-4 text-center font-bold text-gray-500">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100 text-gray-700 text-xs">
                            {{ $businessUnit->order }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($businessUnit->thumbnail_url)
                            <img src="{{ $businessUnit->thumbnail_url }}" alt="{{ $businessUnit->name }}"
                                 class="w-12 h-12 object-cover rounded-lg border border-gray-200 shadow-sm"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-12 h-12 bg-gray-100 text-gray-500 rounded-lg hidden items-center justify-center">
                                <i class="fas fa-{{ $businessUnit->icon ?: 'building' }} text-lg"></i>
                            </div>
                        @else
                            <div class="w-12 h-12 bg-gray-100 text-gray-500 rounded-lg flex items-center justify-center border border-gray-200">
                                <i class="fas fa-{{ $businessUnit->icon ?: 'building' }} text-lg"></i>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.business-units.show', $businessUnit) }}" class="font-bold text-gray-900 hover:text-rose-600 transition">
                            {{ $businessUnit->name }}
                        </a>
                        <div class="text-xs text-gray-400 mt-0.5 font-mono">
                            /unit-bisnis/{{ $businessUnit->slug }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-md bg-blue-50 text-blue-700 border border-blue-100">
                            {{ $businessUnit->category }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600 max-w-xs truncate" title="{{ $businessUnit->services }}">
                        {{ $businessUnit->services ? Str::limit($businessUnit->services, 45) : '-' }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($businessUnit->is_active)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.business-units.show', $businessUnit) }}"
                               class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition"
                               title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.business-units.edit', $businessUnit) }}"
                               class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                               title="Edit Unit Bisnis">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.business-units.destroy', $businessUnit) }}"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus unit bisnis \'{{ $businessUnit->name }}\'?')"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus Unit Bisnis">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                        <div class="max-w-sm mx-auto">
                            <div class="w-16 h-16 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center mx-auto mb-3 text-2xl">
                                <i class="fas fa-building"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 text-base mb-1">Belum Ada Unit Bisnis</h4>
                            <p class="text-sm text-gray-500 mb-4">Tambahkan unit bisnis baru untuk ditampilkan pada profil publik KDMP.</p>
                            <a href="{{ route('admin.business-units.create') }}" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-semibold transition inline-flex items-center gap-2">
                                <i class="fas fa-plus"></i> Tambah Unit Bisnis
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($businessUnits->hasPages())
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        {{ $businessUnits->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection