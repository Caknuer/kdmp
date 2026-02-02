<x-filament::page>
    <style>
        .fs-wrap { display: grid; gap: 18px; }
        .fs-card{
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 18px;
            background: #ffffff;
            box-shadow: 0 6px 18px rgba(0,0,0,.05);
        }
        .fs-heading{
            font-size: 1.05rem;
            font-weight: 800;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        .fs-help{
            font-size: 12px;
            color: #64748b;
            margin-top: -6px;
            margin-bottom: 8px;
        }
    </style>

     <form wire:submit.prevent="save" class="space-y-6">

        {{ $this->form }}

        <x-filament::button type="submit" color="primary">
            Simpan Settings
        </x-filament::button>

    </form>
</x-filament::page>