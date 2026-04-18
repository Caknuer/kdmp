<x-filament::section>
    <x-slot name="heading">
        <div class="flex items-center gap-2">
            <svg class="h-5 w-5 text-rose-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
            </svg>
            Ringkasan Keuangan
        </div>
    </x-slot>

    @php
        $income = $this->getIncome();
        $expense = $this->getExpense();
        $saldo = $this->getSaldo();
    @endphp

    <div class="space-y-4">
        <!-- Income -->
        <div class="rounded-lg border border-green-200/50 bg-gradient-to-r from-green-50 to-emerald-50 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <span class="block text-sm font-medium text-green-700">Pemasukan</span>
                    <span class="block text-2xl font-bold text-green-900">Rp {{ number_format($income) }}</span>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100">
                    <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Expense -->
        <div class="rounded-lg border border-red-200/50 bg-gradient-to-r from-red-50 to-rose-50 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <span class="block text-sm font-medium text-red-700">Pengeluaran</span>
                    <span class="block text-2xl font-bold text-red-900">Rp {{ number_format($expense) }}</span>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-red-100">
                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="h-px bg-gradient-to-r from-gray-200 via-gray-300 to-gray-200"></div>

        <!-- Balance -->
        <div class="rounded-lg border {{ $saldo >= 0 ? 'border-blue-200/50 bg-gradient-to-r from-blue-50 to-cyan-50' : 'border-amber-200/50 bg-gradient-to-r from-amber-50 to-orange-50' }} p-4">
            <div class="flex items-center justify-between">
                <div>
                    <span class="block text-sm font-medium {{ $saldo >= 0 ? 'text-blue-700' : 'text-amber-700' }}">Saldo Bersih</span>
                    <span class="block text-2xl font-bold {{ $saldo >= 0 ? 'text-blue-900' : 'text-amber-900' }}">Rp {{ number_format($saldo) }}</span>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-lg {{ $saldo >= 0 ? 'bg-blue-100' : 'bg-amber-100' }}">
                    <svg class="h-6 w-6 {{ $saldo >= 0 ? 'text-blue-600' : 'text-amber-600' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-2 text-xs font-medium {{ $saldo >= 0 ? 'text-blue-600' : 'text-amber-600' }}">
                {{ $saldo >= 0 ? '✓ Surplus' : '⚠ Deficit' }}
            </div>
        </div>
    </div>
</x-filament::section>
