@extends('admin.layouts.app')

@section('title', 'Daftar Anggota')
@section('page_title', 'Manajemen Anggota')
@section('page_subtitle', 'Kelola data anggota KDMP Wonokerto')

@section('content')
<!-- Header with Search and Button -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex-1">
            <form action="{{ route('admin.members.index') }}" method="GET" class="flex gap-2">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari anggota (nama, email, NIK, atau kode)..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                </div>
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                <button type="submit" class="px-6 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg transition">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <a href="{{ route('admin.members.create') }}" 
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
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Kode</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Telepon</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($members as $member)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-700 font-mono">{{ $member->code }}</td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ $member->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $member->email }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $member->phone }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold 
                            @if($member->status === 'approved') bg-green-100 text-green-800
                            @elseif($member->status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            @if($member->status === 'approved') Disetujui
                            @elseif($member->status === 'pending') Menunggu
                            @else Ditolak @endif
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.members.show', $member) }}" 
                               class="px-3 py-1 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded transition text-xs font-semibold">
                                Lihat
                            </a>
                            @if($member->status !== 'approved')
                            <form action="{{ route('admin.members.approve', $member) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="px-3 py-1 bg-green-50 text-green-600 hover:bg-green-100 rounded transition text-xs font-semibold">
                                    Setujui
                                </button>
                            </form>
                            <a href="{{ route('admin.members.edit', $member) }}" 
                               class="px-3 py-1 bg-yellow-50 text-yellow-600 hover:bg-yellow-100 rounded transition text-xs font-semibold">
                                Edit
                            </a>
                            @endif
                            <form action="{{ route('admin.members.destroy', $member) }}" method="POST" 
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
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-3xl mb-2"></i>
                        <p class="mt-2">Tidak ada anggota yang ditemukan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $members->links() }}
    </div>
</div>
@endsection
