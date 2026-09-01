@extends('admin.layouts.app')

@section('title', 'Detail Artikel - ' . $article->title)
@section('page_title', 'Detail Artikel')
@section('page_subtitle', Str::limit($article->title, 70))

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Top Action Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <a href="{{ route('admin.articles.index') }}"
           class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold transition inline-flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>

        <div class="flex items-center gap-3">
            @if($article->is_published)
                @php
                    $publicUrl = match($article->type) {
                        'pengumuman' => url('/pengumuman/' . $article->slug),
                        'informasi' => url('/informasi/' . $article->slug),
                        default => url('/berita/' . $article->slug),
                    };
                @endphp
                <a href="{{ $publicUrl }}" target="_blank"
                   class="px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg text-sm font-semibold transition inline-flex items-center gap-2 border border-blue-200">
                    <i class="fas fa-external-link-alt"></i> Lihat di Website
                </a>
            @endif
            <a href="{{ route('admin.articles.edit', $article) }}"
               class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-semibold transition inline-flex items-center gap-2 shadow-sm">
                <i class="fas fa-edit"></i> Edit Artikel
            </a>
            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus artikel ini?')" class="inline">
                @csrf @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-sm font-semibold transition inline-flex items-center gap-2 border border-red-200">
                    <i class="fas fa-trash-alt"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Colored Header -->
        @php
            $headerGrad = match($article->type) {
                'pengumuman' => 'from-orange-500 to-orange-600',
                'informasi'  => 'from-purple-600 to-purple-700',
                default      => 'from-blue-600 to-blue-700',
            };
            $typeIcon = match($article->type) {
                'pengumuman' => '📣',
                'informasi'  => 'ℹ️',
                default      => '📰',
            };
        @endphp
        <div class="bg-gradient-to-r {{ $headerGrad }} px-8 py-6 text-white">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-lg">{{ $typeIcon }}</span>
                        <span class="text-sm font-semibold text-white/80 uppercase tracking-wider">
                            {{ ucfirst($article->type) }}
                        </span>
                        @if($article->is_published)
                            <span class="px-2 py-0.5 bg-green-500/90 text-white text-xs font-bold rounded-full">✓ Published</span>
                        @else
                            <span class="px-2 py-0.5 bg-white/20 text-white text-xs font-bold rounded-full">○ Draft</span>
                        @endif
                    </div>
                    <h1 class="text-xl font-bold text-white leading-tight">{{ $article->title }}</h1>
                    <p class="text-white/70 text-sm mt-1">
                        Diterbitkan: {{ $article->display_date?->format('d F Y') ?? 'Belum ditentukan' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Article Metadata Bar -->
        <div class="px-8 py-4 bg-gray-50 border-b border-gray-200 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <div>
                <span class="text-gray-500 text-xs uppercase font-semibold block">Slug</span>
                <span class="font-mono text-gray-700 text-xs">{{ $article->slug }}</span>
            </div>
            <div>
                <span class="text-gray-500 text-xs uppercase font-semibold block">Dibuat</span>
                <span class="text-gray-700">{{ $article->created_at->format('d M Y') }}</span>
            </div>
            <div>
                <span class="text-gray-500 text-xs uppercase font-semibold block">Diperbarui</span>
                <span class="text-gray-700">{{ $article->updated_at->format('d M Y H:i') }}</span>
            </div>
            <div>
                <span class="text-gray-500 text-xs uppercase font-semibold block">Thumbnail</span>
                <span class="text-gray-700">{{ $article->thumbnail ? 'Ada' : 'Tidak ada' }}</span>
            </div>
        </div>

        <!-- Content Body -->
        <div class="p-8">
            <!-- Thumbnail jika ada -->
            @if($article->thumbnail)
            <div class="mb-6">
                <img src="{{ asset('storage/' . $article->thumbnail) }}"
                     alt="{{ $article->title }}"
                     class="w-full max-w-lg rounded-xl shadow-md object-cover max-h-64"
                     onerror="this.style.display='none'">
            </div>
            @endif

            <!-- Isi artikel -->
            <div class="prose prose-gray max-w-none text-gray-800 leading-relaxed">
                {!! $article->content !!}
            </div>
        </div>
    </div>
</div>
@endsection
