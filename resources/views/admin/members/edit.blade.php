@extends('admin.layouts.app')

@section('title', 'Edit Anggota')
@section('page_title', 'Edit Anggota: ' . $member->name)

@section('content')
<div class="bg-white rounded-lg shadow-md p-8 max-w-3xl">
    <form action="{{ route('admin.members.update', $member) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                <input type="text" name="name" value="{{ old('name', $member->name) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
            </div>

            <!-- NIK -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">NIK *</label>
                <input type="text" name="nik" value="{{ old('nik', $member->nik) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                <input type="email" name="email" value="{{ old('email', $member->email) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
            </div>

            <!-- Phone -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Telepon *</label>
                <input type="text" name="phone" value="{{ old('phone', $member->phone) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
            </div>

            <!-- Gender -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Kelamin *</label>
                <select name="gender" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <option value="">-- Pilih --</option>
                    <option value="male" {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="female" {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                    <option value="other" {{ old('gender', $member->gender) == 'other' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <!-- Role -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Keanggotaan *</label>
                <select name="role" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <option value="">-- Pilih Tipe --</option>
                    <option value="platinum" {{ old('role', $member->role) == 'platinum' ? 'selected' : '' }}>🏆 Platinum - Menabung</option>
                    <option value="premium" {{ old('role', $member->role) == 'premium' ? 'selected' : '' }}>💎 Premium - Anggota Resmi</option>
                </select>
            </div>
        </div>

        <!-- Address -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat *</label>
            <textarea name="address" required rows="3"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">{{ old('address', $member->address) }}</textarea>
        </div>

        <!-- Position & Job -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Posisi</label>
                <input type="text" name="position" value="{{ old('position', $member->position) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pekerjaan</label>
                <input type="text" name="job" value="{{ old('job', $member->job) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
            </div>
        </div>

        <!-- Member Status -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Status Anggota</label>
            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                <option value="pending" {{ old('status', $member->status) === 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                <option value="approved" {{ old('status', $member->status) === 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ old('status', $member->status) === 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>

        <!-- Buttons -->
        <div class="flex gap-3 pt-6 border-t">
            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition font-semibold">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
            <a href="{{ route('admin.members.show', $member) }}" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg transition font-semibold">
                <i class="fas fa-times mr-2"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
