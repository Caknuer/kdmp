@extends('admin.layouts.app')

@section('title', 'Tambah Transaksi')
@section('page_title', 'Catat Transaksi Baru')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
    <form action="{{ route('admin.transactions.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Tab Pilihan Jenis Transaksi -->
        <div class="flex gap-2 mb-6">
            <button type="button" id="btn-member" class="flex-1 py-3 px-4 rounded-lg font-semibold transition border-2 transition"
                    onclick="selectTransactionType('member')">
                Transaksi Anggota
            </button>
            <button type="button" id="btn-cash" class="flex-1 py-3 px-4 rounded-lg font-semibold transition border-2 transition"
                    onclick="selectTransactionType('cash')">
                Kas Masuk/Keluar
            </button>
        </div>

        <input type="hidden" name="transaction_for" id="transaction_for" value="{{ old('transaction_for', 'member') }}">

        <!-- Bagian Transaksi Anggota -->
        <div id="member_section">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Anggota *</label>
            <select name="member_id" id="member_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                <option value="">-- Pilih Anggota --</option>
                @foreach(\App\Models\Member::orderBy('name')->get() as $member)
                    <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                @endforeach
            </select>
            @error('member_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Bagian Kas (hanya untuk Kas Masuk/Keluar) -->
        <div id="cash_section" class="hidden">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Sumber / Kategori</label>
            <input list="categories-cash" name="category" value="{{ old('category') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
            <datalist id="categories-cash">
                @foreach($sourceOptions as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
                @foreach($customCategories as $cat)
                    <option value="{{ $cat }}">{{ ucfirst(str_replace(['_', '-'], [' ', ' '], $cat)) }}</option>
                @endforeach
            </datalist>
            <p class="text-xs text-gray-500 mt-1">Rekomendasi: tabungan_anggota, penghasilan, operasional_unit_bisnis</p>
            @error('category') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Field yang muncul di kedua jenis -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis *</label>
                <select name="type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <option value="">-- Pilih --</option>
                    <option value="credit" {{ old('type') == 'credit' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="debit" {{ old('type') == 'debit' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
                @error('type') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah (Rp) *</label>
                <input type="number" name="amount" value="{{ old('amount') }}" step="0.01" min="0" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                @error('amount') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal *</label>
            <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
            @error('date') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan *</label>
            <input type="text" name="description" value="{{ old('description') }}" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
            @error('description') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-3 pt-6 border-t">
            <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition font-semibold">
                <i class="fas fa-save mr-2"></i> Simpan Transaksi
            </button>
            <a href="{{ route('admin.transactions.index') }}" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg transition font-semibold">
                <i class="fas fa-times mr-2"></i> Batal
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function selectTransactionType(type) {
    document.getElementById('transaction_for').value = type;
    
    const memberSection = document.getElementById('member_section');
    const cashSection = document.getElementById('cash_section');
    const btnMember = document.getElementById('btn-member');
    const btnCash = document.getElementById('btn-cash');
    const memberSelect = document.getElementById('member_id');
    
    if (type === 'member') {
        memberSection.classList.remove('hidden');
        cashSection.classList.add('hidden');
        btnMember.classList.add('bg-rose-600', 'text-white', 'border-rose-600');
        btnMember.classList.remove('border-gray-300', 'text-gray-600');
        btnCash.classList.remove('bg-rose-600', 'text-white', 'border-rose-600');
        btnCash.classList.add('border-gray-300', 'text-gray-600');
        memberSelect.setAttribute('required', 'required');
    } else {
        memberSection.classList.add('hidden');
        cashSection.classList.remove('hidden');
        btnCash.classList.add('bg-rose-600', 'text-white', 'border-rose-600');
        btnCash.classList.remove('border-gray-300', 'text-gray-600');
        btnMember.classList.remove('bg-rose-600', 'text-white', 'border-rose-600');
        btnMember.classList.add('border-gray-300', 'text-gray-600');
        memberSelect.removeAttribute('required');
        memberSelect.value = '';
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    selectTransactionType('{{ old('transaction_for', 'member') }}');
});
</script>
@endpush

@endsection
