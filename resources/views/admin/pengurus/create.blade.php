@extends('admin.layouts.app')

@section('title', 'Tambah Pengurus')
@section('page_title', 'Tambah Pengurus Baru')
@section('page_subtitle', 'Masukkan data pengurus untuk struktur organisasi KDMP')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <form action="{{ route('admin.pengurus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Nama Lengkap -->
                <div class="md:col-span-2">
                    <label for="name_p" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Lengkap Beserta Gelar <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="name_p"
                           id="name_p"
                           value="{{ old('name_p') }}"
                           required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 @error('name_p') border-red-500 @enderror"
                           placeholder="Contoh: H. Ahmad Supriyadi, S.E.">
                    @error('name_p')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jabatan -->
                <div>
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
                        Jabatan Kepengurusan <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="role"
                           id="role"
                           value="{{ old('role') }}"
                           required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 @error('role') border-red-500 @enderror"
                           placeholder="Contoh: Ketua Umum, Sekretaris, Bendahara">
                    @error('role')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Urutan Tampilan -->
                <div>
                    <label for="order" class="block text-sm font-semibold text-gray-700 mb-2">
                        Urutan Tampilan
                    </label>
                    <input type="number"
                           name="order"
                           id="order"
                           value="{{ old('order', $nextOrder ?? 1) }}"
                           min="0"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500"
                           placeholder="1">
                    <p class="mt-1 text-xs text-gray-500">Angka lebih kecil tampil lebih awal (contoh: 1 untuk Ketua Umum).</p>
                    @error('order')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Foto Profil -->
            <div class="mb-6">
                <label for="photo_p" class="block text-sm font-semibold text-gray-700 mb-2">
                    Foto Profil Pengurus
                </label>
                <div class="flex items-start gap-4">
                    <div id="photoPreviewContainer" class="w-20 h-20 rounded-xl bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden flex-shrink-0 text-gray-400">
                        <i class="fas fa-image text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <input type="file"
                               name="photo_p"
                               id="photo_p"
                               accept="image/jpeg,image/png,image/jpg,image/webp,image/gif"
                               onchange="previewPhoto(this)"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100 cursor-pointer">
                        <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, WEBP, GIF. Maksimal 2MB. Disarankan rasio 1:1 (persegi).</p>
                    </div>
                </div>
                @error('photo_p')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Biografi / Keterangan Singkat -->
            <div class="mb-6">
                <label for="bio" class="block text-sm font-semibold text-gray-700 mb-2">
                    Biografi / Deskripsi Singkat
                </label>
                <textarea name="bio"
                          id="bio"
                          rows="4"
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500"
                          placeholder="Tuliskan pengalaman, keahlian, atau profil singkat pengurus...">{{ old('bio') }}</textarea>
                @error('bio')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status Aktif -->
            <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox"
                           name="is_active"
                           value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="w-4 h-4 text-rose-600 rounded border-gray-300 focus:ring-rose-500">
                    <div>
                        <span class="text-sm font-semibold text-gray-800">Status Aktif</span>
                        <p class="text-xs text-gray-500">Jika dicentang, pengurus akan langsung ditampilkan di halaman publik KDMP.</p>
                    </div>
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.pengurus.index') }}"
                   class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-semibold transition flex items-center gap-2 shadow-sm">
                    <i class="fas fa-save"></i> Simpan Pengurus
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewPhoto(input) {
    const container = document.getElementById('photoPreviewContainer');
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
