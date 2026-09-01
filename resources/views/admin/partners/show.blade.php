@extends('admin.layouts.app')

@section('title', 'Detail Mitra')
@section('page_title', 'Detail Mitra')
@section('page_subtitle', $partner->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    @if($partner->logo)
                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}"
                             class="w-16 h-16 object-contain rounded-lg bg-white p-2">
                    @else
                        <div class="w-16 h-16 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-building text-2xl text-white"></i>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ $partner->name }}</h1>
                        <p class="text-blue-100">Mitra Koperasi</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.partners.edit', $partner) }}"
                       class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition font-semibold">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </a>
                    <a href="{{ route('admin.partners.index') }}"
                       class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition font-semibold">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4">
                            <i class="fas fa-info-circle mr-2 text-blue-600"></i> Informasi Dasar
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600">Nama Mitra:</span>
                                <span class="font-semibold text-gray-800">{{ $partner->name }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600">Website:</span>
                                <span class="font-semibold text-gray-800">
                                    @if($partner->website)
                                        <a href="{{ $partner->website }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                            {{ parse_url($partner->website, PHP_URL_HOST) }}
                                            <i class="fas fa-external-link-alt ml-1"></i>
                                        </a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600">Status:</span>
                                <span class="font-semibold">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $partner->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $partner->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600">Urutan Tampilan:</span>
                                <span class="font-semibold text-gray-800">{{ $partner->sort_order }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600">Dibuat:</span>
                                <span class="font-semibold text-gray-800">{{ $partner->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600">Terakhir Update:</span>
                                <span class="font-semibold text-gray-800">{{ $partner->updated_at->format('d M Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-align-left mr-2 text-purple-600"></i> Deskripsi
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        @if($partner->description)
                            <p class="text-gray-700 leading-relaxed">{{ $partner->description }}</p>
                        @else
                            <p class="text-gray-400 italic">Tidak ada deskripsi</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex gap-3">
                    <a href="{{ route('admin.partners.edit', $partner) }}"
                       class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition font-semibold">
                        <i class="fas fa-edit mr-2"></i> Edit Mitra
                    </a>
                    <form method="POST" action="{{ route('admin.partners.destroy', $partner) }}"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus mitra ini? Data yang dihapus tidak dapat dikembalikan.')"
                          class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition font-semibold">
                            <i class="fas fa-trash mr-2"></i> Hapus Mitra
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection