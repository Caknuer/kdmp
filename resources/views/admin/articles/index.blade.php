@extends('admin.layouts.app')

@section('title', 'Kelola Artikel')
@section('page_title', 'Kelola Artikel & Konten')
@section('page_subtitle', 'Kelola semua berita, pengumuman, dan informasi yang ditampilkan di website')

@section('content')

<!-- Stats Row -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
    <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</p>
        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalArticles }}</p>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
        <p class="text-xs font-semibold text-blue-500 uppercase tracking-wider">Berita</p>
        <p class="text-2xl font-bold text-blue-700 mt-1">{{ $totalBerita }}</p>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
        <p class="text-xs font-semibold text-orange-500 uppercase tracking-wider">Pengumuman</p>
        <p class="text-2xl font-bold text-orange-600 mt-1">{{ $totalPengumuman }}</p>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
        <p class="text-xs font-semibold text-purple-500 uppercase tracking-wider">Informasi</p>
        <p class="text-2xl font-bold text-purple-700 mt-1">{{ $totalInformasi }}</p>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
        <p class="text-xs font-semibold text-green-500 uppercase tracking-wider">Published</p>
        <p class="text-2xl font-bold text-green-700 mt-1">{{ $totalPublished }}</p>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Draft</p>
        <p class="text-2xl font-bold text-gray-600 mt-1">{{ $totalDraft }}</p>
    </div>
</div>

<!-- Search & Filter Bar -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
    <form action="{{ route('admin.articles.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
        <div class="relative flex-1 min-w-[200px]">
            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 pointer-events-none">
                <i class="fas fa-search text-sm"></i>
            </span>
            <input type="text" name="search" value="{{ $search }}"
                   placeholder="Cari judul atau isi artikel..."
                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500">
        </div>

        <select name="type" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500">
            <option value="all" {{ $type === 'all' ? 'selected' : '' }}>Semua Tipe</option>
            <option value="berita"     {{ $type === 'berita'     ? 'selected' : '' }}>📰 Berita</option>
            <option value="pengumuman" {{ $type === 'pengumuman' ? 'selected' : '' }}>📣 Pengumuman</option>
            <option value="informasi"  {{ $type === 'informasi'  ? 'selected' : '' }}>ℹ️ Informasi</option>
        </select>

        <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500">
            <option value="all"       {{ $status === 'all'       ? 'selected' : '' }}>Semua Status</option>
            <option value="published" {{ $status === 'published' ? 'selected' : '' }}>✓ Published</option>
            <option value="draft"     {{ $status === 'draft'     ? 'selected' : '' }}>○ Draft</option>
        </select>

        <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white rounded-lg text-sm font-medium transition flex items-center gap-2">
            <i class="fas fa-filter text-xs"></i> Filter
        </button>
        @if($search || $type !== 'all' || $status !== 'all')
            <a href="{{ route('admin.articles.index') }}" class="text-sm text-gray-500 hover:text-gray-700 underline">Reset</a>
        @endif

        <div class="ml-auto flex items-center gap-2">
            <a href="{{ route('admin.articles.create', ['type' => 'berita']) }}"
               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition flex items-center gap-1.5 whitespace-nowrap">
                <i class="fas fa-plus text-xs"></i> Berita
            </a>
            <a href="{{ route('admin.articles.create', ['type' => 'pengumuman']) }}"
               class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg text-sm font-semibold transition flex items-center gap-1.5 whitespace-nowrap">
                <i class="fas fa-plus text-xs"></i> Pengumuman
            </a>
            <a href="{{ route('admin.articles.create', ['type' => 'informasi']) }}"
               class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-semibold transition flex items-center gap-1.5 whitespace-nowrap">
                <i class="fas fa-plus text-xs"></i> Informasi
            </a>
        </div>
    </form>
</div>

<!-- Articles Table -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-5 py-3 text-left w-16">Thumb</th>
                    <th class="px-5 py-3 text-left">Judul & Slug</th>
                    <th class="px-5 py-3 text-left w-32">Tipe</th>
                    <th class="px-5 py-3 text-left w-28 text-center">Status</th>
                    <th class="px-5 py-3 text-left w-32">Tanggal Terbit</th>
                    <th class="px-5 py-3 text-center w-28">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($articles as $article)
                <tr class="hover:bg-gray-50/80 transition">
                    <td class="px-5 py-3">
                        @if($article->thumbnail)
                            <img src="{{ asset('storage/' . $article->thumbnail) }}"
                                 alt="{{ $article->title }}"
                                 class="w-12 h-10 object-cover rounded-md border border-gray-200"
                                 onerror="this.style.display='none'">
                        @else
                            <div class="w-12 h-10 rounded-md bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-400 text-lg font-bold">
                                {{ strtoupper(substr($article->title, 0, 1)) }}
                            </div>
                        @endif
                    </td>
                    <td class="px-5 py-3">
                        <a href="{{ route('admin.articles.show', $article) }}"
                           class="font-semibold text-gray-900 hover:text-rose-600 transition line-clamp-2">
                            {{ Str::limit($article->title, 60) }}
                        </a>
                        <div class="text-xs text-gray-400 mt-0.5 font-mono truncate max-w-xs">
                            /{{ $article->type }}/{{ $article->slug }}
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        @php
                            $typeColors = [
                                'berita'     => 'bg-blue-50 text-blue-700 border-blue-100',
                                'pengumuman' => 'bg-orange-50 text-orange-700 border-orange-100',
                                'informasi'  => 'bg-purple-50 text-purple-700 border-purple-100',
                            ];
                            $typeIcons = [
                                'berita'     => '📰',
                                'pengumuman' => '📣',
                                'informasi'  => 'ℹ️',
                            ];
                            $colorClass = $typeColors[$article->type] ?? 'bg-gray-50 text-gray-600 border-gray-200';
                            $typeIcon   = $typeIcons[$article->type] ?? '📄';
                        @endphp
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-semibold border {{ $colorClass }}">
                            {{ $typeIcon }} {{ ucfirst($article->type) }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-center">
                        @if($article->is_published)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Published
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Draft
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-gray-600 text-sm whitespace-nowrap">
                        {{ $article->display_date?->format('d M Y') ?? '-' }}
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('admin.articles.show', $article) }}"
                               class="p-1.5 text-gray-600 hover:bg-gray-100 rounded-md transition" title="Lihat">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                            <a href="{{ route('admin.articles.edit', $article) }}"
                               class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-md transition" title="Edit">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST"
                                  onsubmit="return confirm('Hapus artikel \'{{ addslashes($article->title) }}\'?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded-md transition" title="Hapus">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <div class="max-w-xs mx-auto">
                            <div class="w-14 h-14 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center text-2xl mx-auto mb-3">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <p class="font-semibold text-gray-700 mb-1">Belum ada artikel</p>
                            <p class="text-sm text-gray-500">Mulai buat berita, pengumuman, atau informasi untuk website.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($articles->hasPages())
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        {{ $articles->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
