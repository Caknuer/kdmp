@extends('admin.layouts.app')

@section('title', 'Detail Unit Bisnis - ' . $businessUnit->name)
@section('page_title', 'Detail Unit Bisnis')
@section('page_subtitle', 'Informasi lengkap mengenai unit bisnis ' . $businessUnit->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Top Action Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <a href="{{ route('admin.business-units.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold transition inline-flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>

        <div class="flex items-center gap-3">
            <a href="{{ url('/unit-bisnis/' . $businessUnit->slug) }}" target="_blank" class="px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg text-sm font-semibold transition inline-flex items-center gap-2 border border-blue-200">
                <i class="fas fa-external-link-alt"></i> Lihat di Web
            </a>
            <a href="{{ route('admin.business-units.edit', $businessUnit) }}" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-semibold transition inline-flex items-center gap-2 shadow-sm">
                <i class="fas fa-edit"></i> Edit Unit Bisnis
            </a>
            <form method="POST" action="{{ route('admin.business-units.destroy', $businessUnit) }}"
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus unit bisnis \'{{ $businessUnit->name }}\'?')"
                  class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-sm font-semibold transition inline-flex items-center gap-2 border border-red-200">
                    <i class="fas fa-trash-alt"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Banner Header -->
        <div class="bg-gradient-to-r from-rose-600 to-rose-700 p-8 text-white">
            <div class="flex flex-col sm:flex-row sm:items-center gap-5">
                @if($businessUnit->thumbnail_url)
                    <img src="{{ $businessUnit->thumbnail_url }}" alt="{{ $businessUnit->name }}"
                         class="w-20 h-20 object-cover rounded-xl border-2 border-white/40 shadow-md bg-white">
                @else
                    <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center text-3xl text-white border border-white/30">
                        <i class="fas fa-{{ $businessUnit->icon ?: 'building' }}"></i>
                    </div>
                @endif
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/20 text-white backdrop-blur-sm">
                            {{ $businessUnit->category }}
                        </span>
                        @if($businessUnit->is_active)
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-500/80 text-white">
                                ✓ Aktif
                            </span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-500/80 text-white">
                                Nonaktif
                            </span>
                        @endif
                    </div>
                    <h1 class="text-2xl font-bold text-white">{{ $businessUnit->name }}</h1>
                    <p class="text-xs text-rose-100 font-mono mt-1">
                        URL Slug: /unit-bisnis/{{ $businessUnit->slug }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Details Content -->
        <div class="p-8 space-y-8">
            <!-- Grid Metadata -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100 text-sm">
                <div>
                    <span class="text-gray-500 text-xs uppercase font-semibold block">Urutan Tampilan</span>
                    <span class="font-bold text-gray-800 text-base mt-0.5 block">Urutan ke-{{ $businessUnit->order }}</span>
                </div>
                <div>
                    <span class="text-gray-500 text-xs uppercase font-semibold block">Ikon Terpasang</span>
                    <span class="font-bold text-gray-800 text-base mt-0.5 inline-flex items-center gap-2">
                        <i class="fas fa-{{ $businessUnit->icon ?: 'building' }} text-rose-600"></i> {{ $businessUnit->icon ?: 'building (default)' }}
                    </span>
                </div>
                <div>
                    <span class="text-gray-500 text-xs uppercase font-semibold block">Tanggal Dibuat</span>
                    <span class="font-bold text-gray-800 text-base mt-0.5 block">{{ $businessUnit->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>

            <!-- Layanan / Produk -->
            <div>
                <h3 class="text-base font-bold text-gray-900 mb-3 flex items-center gap-2">
                    <i class="fas fa-cogs text-rose-600"></i> Layanan & Produk yang Disediakan
                </h3>
                <div class="p-5 bg-white border border-gray-200 rounded-xl text-gray-700 text-sm leading-relaxed whitespace-pre-line">
                    {{ $businessUnit->services ?: 'Belum ada rincian layanan khusus yang ditambahkan.' }}
                </div>
            </div>

            <!-- Deskripsi Lengkap -->
            <div>
                <h3 class="text-base font-bold text-gray-900 mb-3 flex items-center gap-2">
                    <i class="fas fa-align-left text-rose-600"></i> Deskripsi Unit Bisnis
                </h3>
                <div class="p-5 bg-white border border-gray-200 rounded-xl text-gray-700 text-sm leading-relaxed whitespace-pre-line">
                    {{ $businessUnit->description ?: 'Belum ada deskripsi unit bisnis yang ditambahkan.' }}
                </div>
            </div>

            <!-- Full Thumbnail View -->
            @if($businessUnit->thumbnail_url)
            <div>
                <h3 class="text-base font-bold text-gray-900 mb-3 flex items-center gap-2">
                    <i class="fas fa-image text-rose-600"></i> Foto / Thumbnail Unit
                </h3>
                <div class="p-2 bg-gray-50 border border-gray-200 rounded-xl inline-block max-w-md">
                    <img src="{{ $businessUnit->thumbnail_url }}" alt="{{ $businessUnit->name }}"
                         class="rounded-lg w-full max-h-72 object-cover">
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection