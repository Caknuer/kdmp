@php
    use App\Filament\Resources\Articles\ArticleResource;
    use App\Filament\Resources\FinancialTransactions\FinancialTransactionResource;
    use App\Filament\Resources\Members\MemberResource;
    use App\Filament\Resources\BusinessUnits\BusinessUnitResource;
@endphp

<x-filament::section>
    <x-slot name="heading">Aksi Cepat</x-slot>

    <div class="grid gap-2">

        <x-filament::button
            tag="a"
            icon="heroicon-m-plus"
            href="{{ ArticleResource::getUrl('create') }}"
        >
            Tambah Artikel
        </x-filament::button>

        <x-filament::button
            tag="a"
            color="success"
            icon="heroicon-m-banknotes"
            href="{{ FinancialTransactionResource::getUrl('create') }}"
        >
            Tambah Transaksi
        </x-filament::button>

        <x-filament::button
            tag="a"
            color="gray"
            icon="heroicon-m-user-plus"
            href="{{ MemberResource::getUrl('create') }}"
        >
            Tambah Member
        </x-filament::button>

        <x-filament::button
            tag="a"
            color="warning"
            icon="heroicon-m-building-office-2"
            href="{{ BusinessUnitResource::getUrl('create') }}"
        >
            Tambah Unit Bisnis
        </x-filament::button>

    </div>
</x-filament::section>
