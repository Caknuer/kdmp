@extends('admin.layouts.app')

@section('title', 'Kelola Halaman Tentang')
@section('page_title', 'Profil Organisasi')
@section('page_subtitle', 'Kelola konten profil organisasi KDMP')

@section('content')
<!-- Tabs Navigation -->
<div class="bg-white rounded-t-lg shadow-sm border border-b-0 border-gray-200 mb-0">
    <div class="flex flex-wrap">
        <a href="{{ route('admin.profile.about') }}" 
           class="px-6 py-4 font-semibold text-sm border-b-2 {{ request()->routeIs('admin.profile.about') ? 'border-rose-600 text-rose-600' : 'border-transparent text-gray-600 hover:text-rose-600' }}">
            <i class="fas fa-file-alt mr-2"></i> Halaman Tentang
        </a>
        <a href="{{ route('admin.pengurus.index') }}" 
           class="px-6 py-4 font-semibold text-sm border-b-2 border-transparent text-gray-600 hover:text-rose-600">
            <i class="fas fa-user-tie mr-2"></i> Pengurus KDMP
        </a>
        <a href="{{ route('admin.pengawas.index') }}" 
           class="px-6 py-4 font-semibold text-sm border-b-2 border-transparent text-gray-600 hover:text-rose-600">
            <i class="fas fa-user-shield mr-2"></i> Pengawas KDMP
        </a>
    </div>
</div>

<div class="bg-white rounded-b-lg shadow-sm border border-gray-200 p-8">
    <form action="{{ route('admin.profile.about.update') }}" method="POST">
        @csrf

        <!-- Profil Singkat -->
        <div class="mb-6">
            <label for="profil_singkat" class="block text-sm font-semibold text-gray-700 mb-2">
                Profil Singkat <span class="text-red-500">*</span>
            </label>
            <textarea name="profil_singkat"
                      id="profil_singkat"
                      rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500"
                      placeholder="Deskripsikan profil singkat organisasi...">{{ old('profil_singkat', $about->profil_singkat ?? '') }}</textarea>
            @error('profil_singkat')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Visi -->
        <div class="mb-6">
            <label for="visi" class="block text-sm font-semibold text-gray-700 mb-2">
                Visi <span class="text-red-500">*</span>
            </label>
            <textarea name="visi"
                      id="visi"
                      rows="3"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500"
                      placeholder="Visi organisasi...">{{ old('visi', $about->visi ?? '') }}</textarea>
            @error('visi')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Misi -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Misi <span class="text-red-500">*</span>
            </label>
            <div id="misi-container">
                @php
                    $misiData = old('misi', $about->misi ?? []);
                    if (!is_array($misiData)) {
                        $misiData = [];
                    }
                @endphp
                @if(count($misiData) > 0)
                    @foreach($misiData as $index => $misi)
                        <div class="misi-item flex gap-2 mb-2">
                            <input type="text"
                                   name="misi[]"
                                   value="{{ is_string($misi) ? $misi : '' }}"
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500"
                                   placeholder="Misi {{ $index + 1 }}">
                            <button type="button" class="remove-misi px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="misi-item flex gap-2 mb-2">
                        <input type="text"
                               name="misi[]"
                               value=""
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500"
                               placeholder="Misi 1">
                        <button type="button" class="remove-misi px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                @endif
            </div>
            <button type="button" id="add-misi" class="mt-2 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                <i class="fas fa-plus mr-2"></i> Tambah Misi
            </button>
            @error('misi')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            @error('misi.*')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nilai -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Nilai <span class="text-red-500">*</span>
            </label>
            <div id="nilai-container">
                @php
                    $nilaiData = old('nilai', $about->nilai ?? []);
                    if (!is_array($nilaiData)) {
                        $nilaiData = [];
                    }
                @endphp
                @if(count($nilaiData) > 0)
                    @foreach($nilaiData as $index => $nilai)
                        <div class="nilai-item flex gap-2 mb-2">
                            <input type="text"
                                   name="nilai[]"
                                   value="{{ is_string($nilai) ? $nilai : '' }}"
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500"
                                   placeholder="Nilai {{ $index + 1 }}">
                            <button type="button" class="remove-nilai px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="nilai-item flex gap-2 mb-2">
                        <input type="text"
                               name="nilai[]"
                               value=""
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500"
                               placeholder="Nilai 1">
                        <button type="button" class="remove-nilai px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                @endif
            </div>
            <button type="button" id="add-nilai" class="mt-2 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                <i class="fas fa-plus mr-2"></i> Tambah Nilai
            </button>
            @error('nilai')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            @error('nilai.*')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit -->
        <div class="flex gap-3">
            <button type="submit" class="px-6 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg transition">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
            <a href="{{ route('admin.dashboard') }}" class="px-6 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Misi management
    const misiContainer = document.getElementById('misi-container');
    const addMisiBtn = document.getElementById('add-misi');

    addMisiBtn.addEventListener('click', function() {
        const itemCount = misiContainer.querySelectorAll('.misi-item').length;
        const newItem = document.createElement('div');
        newItem.className = 'misi-item flex gap-2 mb-2';
        newItem.innerHTML = `
            <input type="text" name="misi[]" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500" placeholder="Misi ${itemCount + 1}">
            <button type="button" class="remove-misi px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                <i class="fas fa-trash"></i>
            </button>
        `;
        misiContainer.appendChild(newItem);
        attachRemoveListeners();
    });

    // Nilai management
    const nilaiContainer = document.getElementById('nilai-container');
    const addNilaiBtn = document.getElementById('add-nilai');

    addNilaiBtn.addEventListener('click', function() {
        const itemCount = nilaiContainer.querySelectorAll('.nilai-item').length;
        const newItem = document.createElement('div');
        newItem.className = 'nilai-item flex gap-2 mb-2';
        newItem.innerHTML = `
            <input type="text" name="nilai[]" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500" placeholder="Nilai ${itemCount + 1}">
            <button type="button" class="remove-nilai px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                <i class="fas fa-trash"></i>
            </button>
        `;
        nilaiContainer.appendChild(newItem);
        attachRemoveListeners();
    });

    function attachRemoveListeners() {
        document.querySelectorAll('.remove-misi, .remove-nilai').forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.misi-item, .nilai-item').remove();
            });
        });
    }

    attachRemoveListeners();

    // Initialize with at least one item if empty
    if (misiContainer.querySelectorAll('.misi-item').length === 0) {
        addMisiBtn.click();
    }
    if (nilaiContainer.querySelectorAll('.nilai-item').length === 0) {
        addNilaiBtn.click();
    }
});
</script>
</div>
@endsection