@extends('admin.layouts.app')

@section('title', 'Tambah Anggota')
@section('page_title', 'Tambah Anggota Baru')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8 max-w-3xl">
    <form action="{{ route('admin.members.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500 {{ $errors->has('name') ? 'border-red-500' : '' }}">
                @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- NIK -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">NIK *</label>
                <input type="text" name="nik" value="{{ old('nik') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500 {{ $errors->has('nik') ? 'border-red-500' : '' }}">
                @error('nik') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500 {{ $errors->has('email') ? 'border-red-500' : '' }}">
                @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Phone -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Telepon *</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500 {{ $errors->has('phone') ? 'border-red-500' : '' }}">
                @error('phone') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Gender -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Kelamin *</label>
                <select name="gender" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <option value="">-- Pilih --</option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('gender') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Role -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Keanggotaan *</label>
                <select name="role" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <option value="">-- Pilih Tipe --</option>
                    <option value="platinum" {{ old('role') == 'platinum' ? 'selected' : '' }}>🏆 Platinum - Menabung</option>
                    <option value="premium" {{ old('role') == 'premium' ? 'selected' : '' }}>💎 Premium - Anggota Resmi</option>
                </select>
                @error('role') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Address -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat *</label>
            <textarea name="address" required rows="3"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500 {{ $errors->has('address') ? 'border-red-500' : '' }}">{{ old('address') }}</textarea>
            @error('address') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Position & Job (Optional) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Posisi (Opsional)</label>
                <input type="text" name="position" value="{{ old('position') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pekerjaan (Opsional)</label>
                <input type="text" name="job" value="{{ old('job') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex gap-3 pt-6 border-t">
            <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition font-semibold">
                <i class="fas fa-save mr-2"></i> Simpan Anggota
            </button>
            <a href="{{ route('admin.members.index') }}" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg transition font-semibold">
                <i class="fas fa-times mr-2"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
