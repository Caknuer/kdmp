<x-filament::page>
    <div class="space-y-6">
        <div class="rounded-lg bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900">Pengaturan Website</h2>
            <p class="text-sm text-gray-600 mt-1">Kelola semua konfigurasi branding, hero, footer, dan kontak KDMP dari sini.</p>
        </div>

        <form wire:submit.prevent="save" class="space-y-6">
            {{ $this->form }}

            <div class="flex gap-4">
                <x-filament::button type="submit" color="primary" icon="heroicon-m-check">
                    Simpan Semua Settings
                </x-filament::button>
                <x-filament::button type="button" color="gray" wire:click="$refresh">
                    Reset
                </x-filament::button>
            </div>
        </form>
    </div>
</x-filament::page>