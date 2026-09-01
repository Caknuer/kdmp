@extends('admin.layouts.app')

@section('title', 'Buat Artikel Baru')
@section('page_title', 'Buat Artikel Baru')
@section('page_subtitle', 'Tambahkan konten berita, pengumuman, atau informasi untuk website KDMP')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Judul -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Judul Artikel <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="title"
                           name="title"
                           value="{{ old('title') }}"
                           required
                           placeholder="Judul berita, pengumuman, atau informasi..."
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipe -->
                <div>
                    <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tipe Konten <span class="text-red-500">*</span>
                    </label>
                    <select id="type" name="type" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 @error('type') border-red-500 @enderror">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="berita"     {{ old('type', $defaultType) === 'berita'     ? 'selected' : '' }}>📰 Berita</option>
                        <option value="pengumuman" {{ old('type', $defaultType) === 'pengumuman' ? 'selected' : '' }}>📣 Pengumuman</option>
                        <option value="informasi"  {{ old('type', $defaultType) === 'informasi'  ? 'selected' : '' }}>ℹ️ Informasi Umum</option>
                    </select>
                    @error('type')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Published At -->
                <div>
                    <label for="published_at" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tanggal Terbit (Opsional)
                    </label>
                    <input type="date"
                           id="published_at"
                           name="published_at"
                           value="{{ old('published_at', now()->format('Y-m-d')) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan untuk menggunakan tanggal hari ini saat dipublikasikan.</p>
                </div>
            </div>

            <!-- Thumbnail Upload -->
            <div class="mb-6">
                <label for="thumbnail" class="block text-sm font-semibold text-gray-700 mb-2">
                    Thumbnail / Gambar Utama (Opsional)
                </label>
                <div class="flex items-start gap-4">
                    <div id="thumbPreview" class="w-24 h-20 rounded-lg bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden flex-shrink-0 text-gray-400">
                        <i class="fas fa-image text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <input type="file"
                               id="thumbnail"
                               name="thumbnail"
                               accept="image/*"
                               onchange="previewThumb(this)"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100 cursor-pointer">
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP. Maks 2MB. Disarankan rasio 16:9 atau 4:3.</p>
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
                          placeholder="Tulis isi artikel, berita, atau pengumuman di sini. Mendukung HTML untuk formatting (heading, bold, list, dll)..."
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 font-mono @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
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
                           {{ old('is_published', true) ? 'checked' : '' }}
                           class="w-4 h-4 text-rose-600 rounded border-gray-300 focus:ring-rose-500">
                    <div>
                        <span class="text-sm font-semibold text-gray-800">Publikasikan Sekarang</span>
                        <p class="text-xs text-gray-500">Konten yang dipublikasikan akan langsung tampil di website publik KDMP.</p>
                    </div>
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.articles.index') }}"
                   class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-semibold transition flex items-center gap-2 shadow-sm">
                    <i class="fas fa-save"></i> Simpan Artikel
                </button>
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
