@php
    use App\Filament\Resources\Articles\ArticleResource;
    use App\Filament\Resources\FinancialTransactions\FinancialTransactionResource;
    use App\Filament\Resources\Members\MemberResource;
    use App\Filament\Resources\BusinessUnits\BusinessUnitResource;
@endphp

<x-filament::section>
    <x-slot name="heading">
        <div class="flex items-center gap-2">
            <svg class="h-5 w-5 text-rose-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.3 5.71L11 13.41l-3.29-3.29c-.63-.63-1.65-.63-2.28 0-.63.63-.63 1.65 0 2.28l4.41 4.41c.39.39.9.59 1.42.59.53 0 1.04-.2 1.42-.59l5.59-5.59c.63-.63.63-1.65 0-2.28-.63-.63-1.65-.63-2.28 0z"/>
            </svg>
            Aksi Cepat
        </div>
    </x-slot>

    <div class="grid gap-3">
        <x-filament::button
            tag="a"
            color="primary"
            icon="heroicon-m-plus"
            href="{{ ArticleResource::getUrl('create') }}"
            class="w-full justify-center"
        >
            <span>Tambah Artikel</span>
        </x-filament::button>

        <x-filament::button
            tag="a"
            color="success"
            icon="heroicon-m-banknotes"
            href="{{ FinancialTransactionResource::getUrl('create') }}"
            class="w-full justify-center"
        >
            <span>Tambah Transaksi</span>
        </x-filament::button>

        <x-filament::button
            tag="a"
            color="info"
            icon="heroicon-m-users"
            href="{{ MemberResource::getUrl('index') }}"
            class="w-full justify-center"
        >
            <span>Daftar Anggota</span>
        </x-filament::button>

        <x-filament::button
            tag="a"
            color="warning"
            icon="heroicon-m-building-office-2"
            href="{{ BusinessUnitResource::getUrl('index') }}"
            class="w-full justify-center"
        >
            <span>Unit Bisnis</span>
        </x-filament::button>
    </div>
</x-filament::section>
