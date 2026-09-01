@extends('admin.layouts.app')

@section('title', 'Pengaturan Website')
@section('page_title', 'Pengaturan Website')
@section('page_subtitle', 'Kelola informasi dan konfigurasi website')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8">
    <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- Informasi Dasar -->
        <div class="border-b pb-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-info-circle mr-2 text-rose-600"></i> Informasi Dasar
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Website *</label>
                    <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? '') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Website</label>
                    <textarea name="site_description" rows="3" maxlength="500"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500"
                              placeholder="Deskripsi singkat tentang website">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Maksimal 500 karakter</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Keywords Website</label>
                    <input type="text" name="site_keywords" value="{{ old('site_keywords', $settings['site_keywords'] ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500"
                           placeholder="koperasi, kdmp, wonokerto, simpan pinjam">
                    <p class="text-xs text-gray-500 mt-1">Pisahkan dengan koma</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat *</label>
                    <textarea name="address" required rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">{{ old('address', $settings['address'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Branding & Assets -->
        <div class="border-b pb-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-image mr-2 text-indigo-600"></i> Branding & Assets
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Logo -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Logo Website</label>
                    @if(isset($settings['site_logo']) && $settings['site_logo'])
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Current Logo" class="w-32 h-32 object-contain border border-gray-300 rounded-lg">
                        </div>
                    @endif
                    <input type="file" name="site_logo" accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <p class="text-xs text-gray-500 mt-1">Format: PNG, JPG, JPEG, SVG. Maksimal 2MB</p>
                </div>

                <!-- Navicon/Favicon -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Navicon/Favicon</label>
                    @if(isset($settings['site_favicon']) && $settings['site_favicon'])
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $settings['site_favicon']) }}" alt="Current Navicon" class="w-16 h-16 object-contain border border-gray-300 rounded-lg">
                        </div>
                    @endif
                    <input type="file" name="site_favicon" accept="image/*,.ico"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <p class="text-xs text-gray-500 mt-1">Format: PNG, JPG, JPEG, ICO. Maksimal 1MB</p>
                </div>
            </div>
        </div>

        <!-- Hero Section -->
        <div class="border-b pb-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-star mr-2 text-yellow-600"></i> Hero Section
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Hero Badge</label>
                    <input type="text" name="hero_badge" value="{{ old('hero_badge', $settings['hero_badge'] ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500"
                           placeholder="KDMP • Transparan • Profesional">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Hero Title</label>
                    <input type="text" name="hero_title" value="{{ old('hero_title', $settings['hero_title'] ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500"
                           placeholder="Membangun Desa">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Hero Subtitle</label>
                    <input type="text" name="hero_subtitle" value="{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500"
                           placeholder="Mandiri & Berdaya">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Hero Description</label>
                    <textarea name="hero_description" rows="3" maxlength="1000"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500"
                              placeholder="Deskripsi hero...">{{ old('hero_description', $settings['hero_description'] ?? '') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Maksimal 1000 karakter</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Hero Images</label>
                    @if(isset($settings['hero_images']) && $settings['hero_images'])
                        @php
                            $heroImages = is_array($settings['hero_images']) ? $settings['hero_images'] : json_decode($settings['hero_images'], true) ?? [];
                        @endphp
                        <div class="mb-3 grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($heroImages as $image)
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Hero Image" class="w-full h-24 object-cover border border-gray-300 rounded-lg">
                                    <button type="button" onclick="removeHeroImage('{{ $image }}')" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                        ×
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <input type="file" name="hero_images[]" accept="image/*" multiple
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <p class="text-xs text-gray-500 mt-1">Format: PNG, JPG, JPEG. Maksimal 5MB per gambar. Rekomendasi: 1920x1080px. Pilih beberapa gambar untuk slideshow.</p>
                </div>
            </div>
        </div>
        <div class="border-b pb-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-phone mr-2 text-blue-600"></i> Kontak
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Telepon *</label>
                    <input type="text" name="phone" value="{{ old('phone', $settings['phone'] ?? '') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $settings['email'] ?? '') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                </div>
            </div>
        </div>

        <!-- Deskripsi Footer -->
        <div class="border-b pb-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-align-left mr-2 text-purple-600"></i> Deskripsi Footer
            </h3>
            <div>
                <textarea name="footer_description" required rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">{{ old('footer_description', $settings['footer_description'] ?? '') }}</textarea>
            </div>
        </div>

        <!-- Maps -->
        <div class="border-b pb-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-map-marker-alt mr-2 text-green-600"></i> Google Maps
            </h3>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">URL Maps (Opsional)</label>
                <input type="text" name="gmaps_url" value="{{ old('gmaps_url', $settings['gmaps_url'] ?? '') }}"
                       placeholder="https://www.google.com/maps/place/..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                <p class="text-xs text-gray-500 mt-2">Dapatkan dari Google Maps dan copy URL tempat Anda</p>
            </div>
        </div>

        <!-- Media Sosial -->
        <div class="border-b pb-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-share-alt mr-2 text-pink-600"></i> Media Sosial
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Facebook</label>
                    <input type="url" name="facebook" value="{{ old('facebook', $settings['facebook'] ?? '') }}"
                           placeholder="https://facebook.com/..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Instagram</label>
                    <input type="url" name="instagram" value="{{ old('instagram', $settings['instagram'] ?? '') }}"
                           placeholder="https://instagram.com/..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">TikTok</label>
                    <input type="url" name="tiktok" value="{{ old('tiktok', $settings['tiktok'] ?? $settings['twitter'] ?? '') }}"
                           placeholder="https://www.tiktok.com/@..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">YouTube</label>
                    <input type="url" name="youtube" value="{{ old('youtube', $settings['youtube'] ?? '') }}"
                           placeholder="https://youtube.com/@..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $settings['whatsapp'] ?? '') }}"
                           placeholder="62812xxxxxxxx"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <p class="text-xs text-gray-500 mt-2">Format: 62 (kode negara tanpa +) + nomor telepon</p>
                </div>
            </div>
        </div>

        <!-- Button -->
        <div class="flex gap-3">
            <button type="submit" class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition font-semibold">
                <i class="fas fa-save mr-2"></i> Simpan Semua Pengaturan
            </button>
            <a href="{{ route('admin.dashboard') }}" class="px-8 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg transition font-semibold">
                <i class="fas fa-times mr-2"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
function removeHeroImage(imagePath) {
    if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
        // Create a hidden input to mark image for deletion
        const form = document.querySelector('form');
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'remove_hero_images[]';
        input.value = imagePath;
        form.appendChild(input);

        // Submit the form
        form.submit();
    }
}
</script>
@endsection
