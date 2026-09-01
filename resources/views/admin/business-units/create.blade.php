@extends('admin.layouts.app')

@section('title', 'Tambah Unit Bisnis')
@section('page_title', 'Tambah Unit Bisnis Baru')
@section('page_subtitle', 'Tambahkan unit bisnis atau unit usaha koperasi KDMP')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <form action="{{ route('admin.business-units.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Name -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Unit Bisnis <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           placeholder="Contoh: Unit Toko Sembako, Unit Simpan Pinjam, Unit PPOB"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategori Unit Bisnis <span class="text-red-500">*</span>
                    </label>
                    <select id="category_select"
                            name="category"
                            onchange="toggleCustomCategory(this.value)"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 @error('category') border-red-500 @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                        <option value="__custom__" {{ old('category_custom') ? 'selected' : '' }}>+ Tulis Kategori Baru...</option>
                    </select>

                    <div id="custom_category_wrapper" class="mt-2 {{ old('category_custom') ? '' : 'hidden' }}">
                        <input type="text"
                               id="category_custom"
                               name="category_custom"
                               value="{{ old('category_custom') }}"
                               placeholder="Ketik nama kategori baru..."
                               class="w-full px-4 py-2 border border-rose-300 rounded-lg text-sm bg-rose-50/50 focus:outline-none focus:ring-2 focus:ring-rose-500">
                    </div>

                    @error('category')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Order -->
                <div>
                    <label for="order" class="block text-sm font-semibold text-gray-700 mb-2">
                        Urutan Tampilan
                    </label>
                    <input type="number"
                           id="order"
                           name="order"
                           value="{{ old('order', $nextOrder ?? 1) }}"
                           min="0"
                           placeholder="1"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500">
                    <p class="text-xs text-gray-500 mt-1">Angka lebih kecil tampil lebih awal pada daftar.</p>
                    @error('order')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Icon (FontAwesome) -->
            <div class="mb-6">
                <label for="icon" class="block text-sm font-semibold text-gray-700 mb-2">
                    Ikon FontAwesome (Opsional)
                </label>
                <div class="flex items-center gap-3">
                    <div id="iconPreview" class="w-11 h-11 rounded-lg bg-gray-100 border border-gray-300 flex items-center justify-center text-gray-700 text-lg flex-shrink-0">
                        <i class="fas fa-{{ old('icon', 'building') }}"></i>
                    </div>
                    <input type="text"
                           id="icon"
                           name="icon"
                           value="{{ old('icon', 'store') }}"
                           oninput="updateIconPreview(this.value)"
                           placeholder="Contoh: store, shopping-cart, money-bill-wave, truck, seedling, cog"
                           class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500">
                </div>
                <div class="flex flex-wrap gap-2 mt-2">
                    <span class="text-xs text-gray-400">Pilihan cepat:</span>
                    <button type="button" onclick="selectQuickIcon('store')" class="text-xs px-2 py-0.5 bg-gray-100 hover:bg-gray-200 rounded text-gray-700">store</button>
                    <button type="button" onclick="selectQuickIcon('shopping-basket')" class="text-xs px-2 py-0.5 bg-gray-100 hover:bg-gray-200 rounded text-gray-700">shopping-basket</button>
                    <button type="button" onclick="selectQuickIcon('money-bill-wave')" class="text-xs px-2 py-0.5 bg-gray-100 hover:bg-gray-200 rounded text-gray-700">money-bill-wave</button>
                    <button type="button" onclick="selectQuickIcon('seedling')" class="text-xs px-2 py-0.5 bg-gray-100 hover:bg-gray-200 rounded text-gray-700">seedling</button>
                    <button type="button" onclick="selectQuickIcon('handshake')" class="text-xs px-2 py-0.5 bg-gray-100 hover:bg-gray-200 rounded text-gray-700">handshake</button>
                    <button type="button" onclick="selectQuickIcon('truck')" class="text-xs px-2 py-0.5 bg-gray-100 hover:bg-gray-200 rounded text-gray-700">truck</button>
                    <button type="button" onclick="selectQuickIcon('tools')" class="text-xs px-2 py-0.5 bg-gray-100 hover:bg-gray-200 rounded text-gray-700">tools</button>
                </div>
                @error('icon')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Thumbnail Upload with Preview -->
            <div class="mb-6">
                <label for="thumbnail" class="block text-sm font-semibold text-gray-700 mb-2">
                    Foto / Thumbnail Unit Bisnis
                </label>
                <div class="flex items-start gap-4">
                    <div id="thumbPreviewContainer" class="w-24 h-24 rounded-xl bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden flex-shrink-0 text-gray-400">
                        <i class="fas fa-image text-3xl"></i>
                    </div>
                    <div class="flex-1">
                        <input type="file"
                               id="thumbnail"
                               name="thumbnail"
                               accept="image/jpeg,image/png,image/jpg,image/webp,image/gif"
                               onchange="previewThumbnail(this)"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100 cursor-pointer">
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP, GIF. Maksimal 2MB. Disarankan foto lanskap/rasio 16:9 atau 4:3.</p>
                    </div>
                </div>
                @error('thumbnail')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Services -->
            <div class="mb-6">
                <label for="services" class="block text-sm font-semibold text-gray-700 mb-2">
                    Daftar Layanan / Produk yang Disediakan
                </label>
                <textarea id="services"
                          name="services"
                          rows="3"
                          placeholder="Contoh: Sembako murah, Pembayaran Token Listrik & BPJS, Penyaluran Pupuk Desa, dll."
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500">{{ old('services') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Tuliskan layanan unggulan unit bisnis ini (bisa dipisah dengan koma atau baris baru).</p>
                @error('services')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                    Deskripsi Lengkap Unit Bisnis
                </label>
                <textarea id="description"
                          name="description"
                          rows="5"
                          placeholder="Jelaskan mengenai latar belakang, tujuan, dan operasional unit bisnis ini secara lengkap..."
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Is Active -->
            <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox"
                           name="is_active"
                           value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="w-4 h-4 text-rose-600 rounded border-gray-300 focus:ring-rose-500">
                    <div>
                        <span class="text-sm font-semibold text-gray-800">Status Aktif</span>
                        <p class="text-xs text-gray-500">Unit bisnis yang aktif akan langsung tampil di halaman publik KDMP.</p>
                    </div>
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.business-units.index') }}"
                   class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-semibold transition flex items-center gap-2 shadow-sm">
                    <i class="fas fa-save"></i> Simpan Unit Bisnis
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleCustomCategory(value) {
    const wrapper = document.getElementById('custom_category_wrapper');
    const input = document.getElementById('category_custom');
    if (value === '__custom__') {
        wrapper.classList.remove('hidden');
        input.focus();
    } else {
        wrapper.classList.add('hidden');
        input.value = '';
    }
}

function updateIconPreview(name) {
    const preview = document.getElementById('iconPreview');
    const cleanName = name.trim().replace(/^fa-/, '');
    preview.innerHTML = `<i class="fas fa-${cleanName || 'building'}"></i>`;
}

function selectQuickIcon(name) {
    document.getElementById('icon').value = name;
    updateIconPreview(name);
}

function previewThumbnail(input) {
    const container = document.getElementById('thumbPreviewContainer');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            container.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection