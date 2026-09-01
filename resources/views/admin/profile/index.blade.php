@extends('admin.layouts.app')

@section('title', 'Profil Organisasi')
@section('page_title', 'Profil Organisasi')
@section('page_subtitle', 'Kelola konten profil organisasi KDMP')

@section('content')
<!-- Content Area -->
<div class="grid grid-cols-1 lg:grid-cols-1 gap-6 mb-8">
    <a href="{{ route('admin.profile.about') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Halaman Tentang</p>
                <p class="text-2xl font-bold text-gray-800 mt-2">1</p>
                <p class="text-xs text-gray-500 mt-1">Kelola halaman tentang organisasi</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                <i class="fas fa-file-alt text-2xl text-blue-600"></i>
            </div>
        </div>
    </a>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">
        <i class="fas fa-bolt mr-2 text-yellow-600"></i> Aksi Cepat
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
        <a href="{{ route('admin.profile.about') }}" 
           class="p-4 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg transition flex items-center gap-3">
            <i class="fas fa-edit text-xl"></i>
            <div>
                <p class="font-semibold">Edit Halaman Tentang</p>
                <p class="text-xs">Ubah profil, visi, misi, dan nilai organisasi</p>
            </div>
        </a>
    </div>
</div>

<div class="mt-8 p-6 bg-blue-50 border border-blue-200 rounded-lg">
    <div class="flex gap-4">
        <div class="flex-shrink-0">
            <i class="fas fa-info-circle text-2xl text-blue-600"></i>
        </div>
        <div>
            <h4 class="font-semibold text-blue-900 mb-2">Petunjuk Pengelolaan Profil</h4>
            <ul class="text-blue-800 text-sm space-y-1">
                <li>✓ Gunakan halaman tentang untuk mengelola konten profil organisasi</li>
                <li>✓ Fokus pada informasi dan transparansi organisasi</li>
                <li>✓ Update data publik sesuai kebutuhan dari halaman tentang</li>
            </ul>
        </div>
    </div>
</div>

@endsection
