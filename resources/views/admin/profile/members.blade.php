@extends('admin.layouts.app')

@section('title', 'Daftar Anggota Organisasi')
@section('page_title', 'Profil Organisasi')
@section('page_subtitle', 'Kelola konten profil organisasi KDMP')

@section('content')
<!-- Tabs Navigation -->
<div class="bg-white rounded-t-lg shadow-sm border border-b-0 border-gray-200 mb-0">
    <div class="flex flex-wrap">
        <a href="{{ route('admin.profile.about') }}" 
           class="px-6 py-4 font-semibold text-sm border-b-2 border-transparent text-gray-600 hover:text-rose-600">
            <i class="fas fa-file-alt mr-2"></i> Halaman Tentang
        </a>
        <a href="{{ route('admin.pengurus.index') }}" 
           class="px-6 py-4 font-semibold text-sm border-b-2 border-transparent text-gray-600 hover:text-rose-600">
            <i class="fas fa-user-tie mr-2"></i> Pengurus KDMP
        </a>
        <a href="{{ route('admin.pengawas.index') }}" 
           class="px-6 py-4 font-semibold text-sm border-b-2 border-transparent text-gray-600 hover:text-rose-600">
            <i class="fas fa-user-shield mr-2"></i> Pengawas KDMP
        </a>
        <a href="{{ route('admin.profile.members') }}" 
           class="px-6 py-4 font-semibold text-sm border-b-2 {{ request()->routeIs('admin.profile.members*') ? 'border-rose-600 text-rose-600' : 'border-transparent text-gray-600 hover:text-rose-600' }}">
            <i class="fas fa-users mr-2"></i> Semua Organisasi
        </a>
    </div>
</div>

<!-- Header with Search and Button -->
<div class="bg-white rounded-b-lg shadow-md p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex-1">
            <form action="{{ route('admin.profile.members') }}" method="GET" class="flex gap-2">
                <div class="flex-1">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari anggota (nama, jabatan)..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                </div>
                <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>Semua</option>
                    <option value="pengurus" {{ request('type') == 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                    <option value="pengawas" {{ request('type') == 'pengawas' ? 'selected' : '' }}>Pengawas</option>
                </select>
                <button type="submit" class="px-6 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg transition">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <a href="{{ route('admin.profile.members.create') }}"
           class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition flex items-center gap-2">
            <i class="fas fa-user-plus"></i> Tambah Anggota
        </a>
    </div>
</div>

<!-- Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Foto</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jabatan</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tipe</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Urutan</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($members as $member)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm">
                        @if($member->photo_url)
                            <img src="{{ $member->photo_url }}"
                                 alt="{{ $member->name_p }}"
                                 class="w-12 h-12 rounded-full object-cover">
                        @else
                            <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-semibold">
                                {{ strtoupper(substr($member->name_p, 0, 1)) }}
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ $member->name_p }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $member->role }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                            {{ $member->type === 'pengurus' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                            {{ $member->type === 'pengurus' ? 'Pengurus' : 'Pengawas' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                            {{ $member->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $member->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $member->order ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.profile.members.edit', $member) }}"
                               class="px-3 py-1 bg-yellow-50 text-yellow-600 hover:bg-yellow-100 rounded transition text-xs font-semibold">
                                Edit
                            </a>
                            <form action="{{ route('admin.profile.members.destroy', $member) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus anggota ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-3 py-1 bg-red-50 text-red-600 hover:bg-red-100 rounded transition text-xs font-semibold">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-users text-3xl mb-2"></i>
                        <p class="mt-2">Tidak ada anggota organisasi yang ditemukan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($members->hasPages())
    <div class="px-6 py-4 bg-gray-50 border-t">
        {{ $members->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection