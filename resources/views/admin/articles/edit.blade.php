@extends('admin.layouts.app')

@section('title', 'Edit Artikel')
@section('page_title', 'Edit Artikel')
@section('page_subtitle', 'Perbarui konten: ' . Str::limit($article->title, 60))

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Judul -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Judul Artikel <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="title"
                           name="title"
                           value="{{ old('title', $article->title) }}"
                           required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-400 mt-1 font-mono">Slug saat ini: /{{ $article->type }}/{{ $article->slug }}</p>
                </div>

                <!-- Tipe -->
                <div>
                    <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tipe Konten <span class="text-red-500">*</span>
                    </label>
                    <select id="type" name="type" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 @error('type') border-red-500 @enderror">
                        <option value="berita"     {{ old('type', $article->type) === 'berita'     ? 'selected' : '' }}>📰 Berita</option>
                        <option value="pengumuman" {{ old('type', $article->type) === 'pengumuman' ? 'selected' : '' }}>📣 Pengumuman</option>
                        <option value="informasi"  {{ old('type', $article->type) === 'informasi'  ? 'selected' : '' }}>ℹ️ Informasi Umum</option>
                    </select>
                    @error('type')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Published At -->
                <div>
                    <label for="published_at" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tanggal Terbit
                    </label>
                    <input type="date"
                           id="published_at"
                           name="published_at"
                           value="{{ old('published_at', $article->published_at?->format('Y-m-d')) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500">
                </div>
            </div>

            <!-- Thumbnail -->
            <div class="mb-6">
                <label for="thumbnail" class="block text-sm font-semibold text-gray-700 mb-2">
                    Thumbnail / Gambar Utama
                </label>
                <div class="flex items-start gap-4">
                    <div id="thumbPreview" class="w-24 h-20 rounded-lg bg-gray-100 border border-gray-300 flex items-center justify-center overflow-hidden flex-shrink-0 text-gray-400">
                        @if($article->thumbnail)
                            <img src="{{ asset('storage/' . $article->thumbnail) }}"
                                 alt="{{ $article->title }}"
                                 class="w-full h-full object-cover"
                                 onerror="this.parentElement.innerHTML='<i class=\'fas fa-image text-2xl\'></i>'">
                        @else
                            <i class="fas fa-image text-2xl"></i>
                        @endif
                    </div>
                    <div class="flex-1">
                        <input type="file"
                               id="thumbnail"
                               name="thumbnail"
                               accept="image/*"
                               onchange="previewThumb(this)"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100 cursor-pointer">
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti thumbnail. Format: JPG, PNG, WEBP. Maks 2MB.</p>
                        @if($article->thumbnail)
                            <label class="inline-flex items-center gap-2 mt-2 text-xs text-red-600 cursor-pointer">
                                <input type="checkbox" name="remove_thumbnail" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                <span>Hapus thumbnail saat ini</span>
                            </label>
                        @endif
                    </div>
                </div>
                @error('thumbnail')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konten -->
            <div class="mb-6">
                <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">
                    Konten Artikel <span class="text-red-500">*</span>
                </label>
                <textarea id="content"
                          name="content"
                          required
                          rows="14"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 font-mono @error('content') border-red-500 @enderror">{{ old('content', $article->content) }}</textarea>
                <p class="text-xs text-gray-500 mt-1">
                    Mendukung HTML: <code>&lt;b&gt;</code>, <code>&lt;i&gt;</code>, <code>&lt;ul&gt;</code>, <code>&lt;li&gt;</code>, <code>&lt;p&gt;</code>, <code>&lt;h3&gt;</code>, dll.
                </p>
                @error('content')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status Publikasi -->
            <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox"
                           name="is_published"
                           value="1"
                           {{ old('is_published', $article->is_published) ? 'checked' : '' }}
                           class="w-4 h-4 text-rose-600 rounded border-gray-300 focus:ring-rose-500">
                    <div>
                        <span class="text-sm font-semibold text-gray-800">Status Dipublikasikan</span>
                        <p class="text-xs text-gray-500">Konten yang dipublikasikan akan tampil di halaman publik website KDMP.</p>
                    </div>
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                <a href="{{ route('admin.articles.show', $article) }}"
                   class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                    <i class="fas fa-eye"></i> Lihat Detail
                </a>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.articles.index') }}"
                       class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-semibold transition flex items-center gap-2 shadow-sm">
                        <i class="fas fa-save"></i> Perbarui Artikel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function previewThumb(input) {
    const preview = document.getElementById('thumbPreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
