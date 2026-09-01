@extends('admin.layouts.app')

@section('title', 'Tambah Anggota Organisasi')
@section('page_title', 'Tambah Anggota Organisasi')
@section('page_subtitle', 'Tambahkan pengurus atau pengawas baru')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8">
    <form action="{{ route('admin.profile.members.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Nama -->
        <div class="mb-6">
            <label for="name_p" class="block text-sm font-semibold text-gray-700 mb-2">
                Nama Lengkap <span class="text-red-500">*</span>
            </label>
            <input type="text"
                   name="name_p"
                   id="name_p"
                   value="{{ old('name_p') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500"
                   placeholder="Masukkan nama lengkap">
            @error('name_p')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Jabatan -->
        <div class="mb-6">
            <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
                Jabatan <span class="text-red-500">*</span>
            </label>
            <input type="text"
                   name="role"
                   id="role"
                   value="{{ old('role') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500"
                   placeholder="Contoh: Ketua, Sekretaris, dll">
            @error('role')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tipe -->
        <div class="mb-6">
            <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">
                Tipe <span class="text-red-500">*</span>
            </label>
            <select name="type"
                    id="type"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                <option value="">Pilih tipe</option>
                <option value="pengurus" {{ old('type') == 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                <option value="pengawas" {{ old('type') == 'pengawas' ? 'selected' : '' }}>Pengawas</option>
            </select>
            @error('type')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Foto -->
        <div class="mb-6">
            <label for="photo_p" class="block text-sm font-semibold text-gray-700 mb-2">
                Foto Profil
            </label>
            <input type="file"
                   name="photo_p"
                   id="photo_p"
                   accept="image/*"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
            <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, GIF. Maksimal 2MB.</p>
            @error('photo_p')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Bio -->
        <div class="mb-6">
            <label for="bio" class="block text-sm font-semibold text-gray-700 mb-2">
                Biografi
            </label>
            <textarea name="bio"
                      id="bio"
                      rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500"
                      placeholder="Deskripsikan singkat tentang anggota ini...">{{ old('bio') }}</textarea>
            @error('bio')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Urutan -->
        <div class="mb-6">
            <label for="order" class="block text-sm font-semibold text-gray-700 mb-2">
                Urutan Tampilan
            </label>
            <input type="number"
                   name="order"
                   id="order"
                   value="{{ old('order', 0) }}"
                   min="0"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500"
                   placeholder="0">
            <p class="mt-1 text-sm text-gray-500">Urutan tampilan (0 = pertama).</p>
            @error('order')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status Aktif -->
        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox"
                       name="is_active"
                       value="1"
                       {{ old('is_active', true) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-rose-600 focus:ring-rose-500">
                <span class="ml-2 text-sm font-semibold text-gray-700">Aktif</span>
            </label>
            <p class="mt-1 text-sm text-gray-500">Centang untuk menampilkan anggota ini di halaman publik.</p>
        </div>

        <!-- Submit -->
        <div class="flex gap-3">
            <button type="submit" class="px-6 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg transition">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
            <a href="{{ route('admin.profile.members') }}" class="px-6 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection