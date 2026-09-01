@extends('admin.layouts.app')

@section('title', 'Detail Anggota')
@section('page_title', 'Detail Anggota: ' . $member->name)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Info -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Informasi Anggota</h3>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Kode Anggota</p>
                <p class="font-semibold text-gray-800">{{ $member->code }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Nama</p>
                <p class="font-semibold text-gray-800">{{ $member->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">NIK</p>
                <p class="font-mono text-gray-800">{{ $member->nik }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="text-gray-800">{{ $member->email }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Telepon</p>
                <p class="text-gray-800">{{ $member->phone }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Jenis Kelamin</p>
                <p class="text-gray-800">{{ $member->gender }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Peran</p>
                <p class="text-gray-800">{{ $member->role }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Status</p>
                <p class="inline-block px-3 py-1 rounded text-xs font-semibold 
                    @if($member->status === 'approved') bg-green-100 text-green-800
                    @elseif($member->status === 'pending') bg-yellow-100 text-yellow-800
                    @else bg-red-100 text-red-800 @endif">
                    @if($member->status === 'approved') Disetujui
                    @elseif($member->status === 'pending') Menunggu
                    @else Ditolak @endif
                </p>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t flex gap-2">
            <a href="{{ route('admin.members.edit', $member) }}" class="px-6 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <form action="{{ route('admin.members.destroy', $member) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                    <i class="fas fa-trash mr-2"></i> Hapus
                </button>
            </form>
            <a href="{{ route('admin.members.index') }}" class="px-6 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Alamat</h3>
        <p class="text-gray-700 text-sm leading-relaxed">{{ $member->address }}</p>

        <div class="mt-6 pt-6 border-t">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Saldo Anggota</h3>
            <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($member->balance) }}</p>
            <p class="text-sm text-gray-500 mt-1">Saldo dihitung dari transaksi kredit dan debit anggota.</p>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.transactions.create', ['member_id' => $member->id]) }}" class="block w-full text-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition font-semibold">
                <i class="fas fa-wallet mr-2"></i> Tambah Saldo Anggota
            </a>
        </div>

        <div class="mt-6 pt-6 border-t">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Metadata</h3>
            <div class="space-y-3 text-sm">
                <div>
                    <p class="text-gray-500">Dibuat</p>
                    <p class="text-gray-800">{{ $member->created_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Terakhir Diubah</p>
                    <p class="text-gray-800">{{ $member->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
