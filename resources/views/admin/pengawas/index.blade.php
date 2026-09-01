@extends('admin.layouts.app')

@section('title', 'Kelola Pengawas')
@section('page_title', 'Kelola Pengawas KDMP')
@section('page_subtitle', 'Kelola data dewan pengawas, jabatan, foto, dan urutan tampilan struktur pengawas')

@section('content')
<!-- Header Stats & Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Pengawas</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $pengawas->total() }}</p>
        </div>
        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
            <i class="fas fa-user-shield"></i>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Status Aktif</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $totalActive }}</p>
        </div>
        <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-xl">
            <i class="fas fa-check-circle"></i>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Halaman Publik</p>
            <a href="{{ url('/profil/pengawas') }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-semibold text-rose-600 hover:text-rose-700 mt-2">
                Lihat di Web <i class="fas fa-external-link-alt text-xs"></i>
            </a>
        </div>
        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
            <i class="fas fa-globe"></i>
        </div>
    </div>
</div>

<!-- Filter & Action Bar -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 mb-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <form action="{{ route('admin.pengawas.index') }}" method="GET" class="flex flex-wrap items-center gap-3 flex-1">
            <div class="relative flex-1 min-w-[240px]">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari nama atau jabatan pengawas..."
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500">
            </div>

            <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white rounded-lg text-sm font-medium transition flex items-center gap-2">
                <i class="fas fa-filter text-xs"></i> Filter
            </button>

            @if(request('search') || request('status') && request('status') != 'all')
                <a href="{{ route('admin.pengawas.index') }}" class="text-sm text-gray-500 hover:text-gray-700 underline">
                    Reset
                </a>
            @endif
        </form>

        <a href="{{ route('admin.pengawas.create') }}"
           class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-semibold transition flex items-center justify-center gap-2 shadow-sm">
            <i class="fas fa-plus"></i> Tambah Pengawas
        </a>
    </div>
</div>

<!-- Table Container -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-700 uppercase font-semibold text-xs">
                <tr>
                    <th class="px-6 py-4 w-16 text-center">Urutan</th>
                    <th class="px-6 py-4 w-20">Foto</th>
                    <th class="px-6 py-4">Nama Lengkap</th>
                    <th class="px-6 py-4">Jabatan</th>
                    <th class="px-6 py-4">Biografi</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center w-36">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($pengawas as $item)
                <tr class="hover:bg-gray-50/80 transition">
                    <td class="px-6 py-4 text-center font-bold text-gray-500">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100 text-gray-700 text-xs">
                            {{ $item->order }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($item->photo_url)
                            <img src="{{ $item->photo_url }}"
                                 alt="{{ $item->name_p }}"
                                 class="w-12 h-12 rounded-full object-cover border border-gray-200 shadow-sm"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-12 h-12 rounded-full bg-purple-100 text-purple-700 font-bold items-center justify-center hidden text-base">
                                {{ strtoupper(substr($item->name_p, 0, 1)) }}
                            </div>
                        @else
                            <div class="w-12 h-12 rounded-full bg-purple-100 text-purple-700 font-bold flex items-center justify-center text-base">
                                {{ strtoupper(substr($item->name_p, 0, 1)) }}
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900">
                        {{ $item->name_p }}
                    </td>
                    <td class="px-6 py-4 text-gray-700 font-medium">
                        <span class="inline-block px-3 py-1 bg-purple-50 text-purple-800 rounded-md font-medium text-xs border border-purple-100">
                            {{ $item->role }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500 max-w-xs truncate" title="{{ $item->bio }}">
                        {{ $item->bio ? Str::limit($item->bio, 60) : '-' }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($item->is_active)
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
                            <a href="{{ route('admin.pengawas.edit', $item) }}"
                               class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                               title="Edit Pengawas">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.pengawas.destroy', $item) }}"
                                  method="POST"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pengawas ini?')"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                                        title="Hapus Pengawas">
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
                            <div class="w-16 h-16 rounded-full bg-purple-50 text-purple-500 flex items-center justify-center mx-auto mb-3 text-2xl">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 text-base mb-1">Belum Ada Data Pengawas</h4>
                            <p class="text-sm text-gray-500 mb-4">Tambahkan data dewan pengawas untuk ditampilkan di profil KDMP.</p>
                            <a href="{{ route('admin.pengawas.create') }}" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-semibold transition inline-flex items-center gap-2">
                                <i class="fas fa-plus"></i> Tambah Pengawas
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($pengawas->hasPages())
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        {{ $pengawas->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
