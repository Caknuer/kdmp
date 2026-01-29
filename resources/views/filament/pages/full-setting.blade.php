<x-filament::page>
    <style>
        .fs-card{border:1px solid #47acd4;border-radius:12px;padding:1.5rem;margin-bottom:1.5rem;background:#d48f8f;box-shadow:0 4px 6px rgba(0,0,0,.05)}
        .fs-heading{font-size:1.25rem;font-weight:700;margin-bottom:1rem;border-bottom:2px solid #cbd5e1;padding-bottom:.25rem;color:#fff}
        .fs-input,.fs-textarea{width:100%;border:1px solid #cbd5e1;border-radius:8px;padding:.5rem;margin-bottom:.75rem}
        .fs-input:focus,.fs-textarea:focus{outline:none;border-color:#3b82f6;box-shadow:0 0 0 2px rgba(59,130,246,.3)}
    </style>

    <form wire:submit.prevent="save" class="space-y-6">
        <div class="fs-card">
            <h2 class="fs-heading">Footer Settings</h2>

            <label class="block text-sm">Nama Situs</label>
            <input type="text" class="fs-input" wire:model.defer="site_name" placeholder="KDMP Wonokerto">

            <label class="block text-sm">Alamat</label>
            <input type="text" class="fs-input" wire:model.defer="address" placeholder="Alamat lengkap">

            <label class="block text-sm">Deskripsi Footer (opsional)</label>
            <textarea class="fs-textarea" rows="3" wire:model.defer="footer_description"
                      placeholder="Deskripsi singkat yang tampil di footer"></textarea>

            <label class="block text-sm">Email</label>
            <input type="email" class="fs-input" wire:model.defer="email" placeholder="admin@email.com">

            <label class="block text-sm">Telepon</label>
            <input type="text" class="fs-input" wire:model.defer="phone" placeholder="08xxxxxxxxxx">

            <label class="block text-sm">Google Maps Link (Bagikan)</label>
            <input type="text" class="fs-input" wire:model.defer="gmaps_url"
                   placeholder="Tempel link Google Maps versi google.com/maps">

            <p class="text-xs text-white/90 mt-1">
                Tips: buka Google Maps di browser → Bagikan → Salin link (pastikan mengandung <b>google.com/maps</b>).
            </p>
        </div>

        <x-filament::button type="submit">
            Simpan Footer
        </x-filament::button>
    </form>
</x-filament::page>