<x-filament::section>
    <x-slot name="heading">Ringkasan Keuangan</x-slot>

    @php
        $income = $this->getIncome();
        $expense = $this->getExpense();
        $saldo = $this->getSaldo();
    @endphp

    <div class="space-y-3 text-sm">
        <div class="flex items-center justify-between">
            <span class="text-gray-600">Pemasukan</span>
            <span class="font-semibold">Rp {{ number_format($income) }}</span>
        </div>

        <div class="flex items-center justify-between">
            <span class="text-gray-600">Pengeluaran</span>
            <span class="font-semibold">Rp {{ number_format($expense) }}</span>
        </div>

        <div class="h-px bg-gray-200/70"></div>

        <div class="flex items-center justify-between">
            <span class="text-gray-600">Saldo</span>
            <span class="font-semibold {{ $saldo >= 0 ? 'text-green-600' : 'text-red-600' }}">
                Rp {{ number_format($saldo) }}
            </span>
        </div>
    </div>
</x-filament::section>
