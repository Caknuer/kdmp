@extends('admin.layouts.app')

@section('title', 'Kelola Mitra')
@section('page_title', 'Kelola Mitra')
@section('page_subtitle', 'Daftar semua mitra koperasi')

@section('content')
<div class="bg-white rounded-lg shadow-md">
    <!-- Header with Search and Filters -->
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <!-- Search -->
            <div class="flex-1 max-w-md">
                <form method="GET" class="flex gap-2">
                    <input type="text" name="search" value="{{ $search }}"
                           placeholder="Cari mitra..."
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg transition">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- Filters -->
            <div class="flex gap-2">
                <select name="status" onchange="this.form.submit()" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>

                <a href="{{ route('admin.partners.create') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition font-semibold">
                    <i class="fas fa-plus mr-2"></i> Tambah Mitra
                </a>
            </div>
        </div>
    </div>

    <!-- Partners List -->
    <div class="overflow-x-auto">
        @if($partners->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Logo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Mitra</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Website</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urutan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($partners as $partner)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($partner->logo)
                            <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}"
                                 class="w-12 h-12 object-contain rounded-lg border border-gray-200">
                        @else
                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-building text-gray-400 text-lg"></i>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $partner->name }}</div>
                        @if($partner->description)
                            <div class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($partner->description, 50) }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($partner->website)
                            <a href="{{ $partner->website }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-external-link-alt mr-1"></i> {{ parse_url($partner->website, PHP_URL_HOST) }}
                            </a>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $partner->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $partner->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $partner->sort_order }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.partners.show', $partner) }}"
                               class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.partners.edit', $partner) }}"
                               class="text-indigo-600 hover:text-indigo-900">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.partners.destroy', $partner) }}"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus mitra ini?')"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="px-6 py-12 text-center">
            <i class="fas fa-building text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada mitra</h3>
            <p class="text-gray-500 mb-6">Belum ada data mitra yang ditambahkan.</p>
            <a href="{{ route('admin.partners.create') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                <i class="fas fa-plus mr-2"></i> Tambah Mitra Pertama
            </a>
        </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($partners->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        {{ $partners->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection