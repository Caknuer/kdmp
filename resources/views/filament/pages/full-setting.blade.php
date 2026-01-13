<x-filament::page>
    <style>
        /* Card style */
        .fs-card {
            border: 1px solid #47acd4;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            background-color: #d48f8f;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        /* Section heading */
        .fs-heading {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            border-bottom: 2px solid #cbd5e1;
            padding-bottom: 0.25rem;
            color: #ffffff;
        }

        /* Input & textarea */
        .fs-input, .fs-textarea {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .fs-input:focus, .fs-textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
        }

        /* File preview */
        .fs-preview {
            margin-top: 0.5rem;
            max-height: 80px;
            border-radius: 6px;
        }

        /* Submit button */
        .fs-submit {
            background-color: #8e9fb9;
            color: #fff;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            transition: background-color 0.2s;
        }

        .fs-submit:hover {
            background-color: #2563eb;
        }
    </style>

    <form wire:submit.prevent="save">

        {{-- ===== GENERAL SETTINGS ===== --}}
        <div class="fs-card">
            <h2 class="fs-heading">General</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" class="fs-input" placeholder="Nama Situs" wire:model.defer="site_name">
                <input type="text" class="fs-input" placeholder="Tagline" wire:model.defer="tagline">
            </div>
            <label class="block font-medium text-sm mt-4">Google Maps (iframe / URL)</label>
            <textarea class="fs-textarea" rows="4" wire:model.defer="gmaps"></textarea>
            <p class="text-sm text-gray-500 mt-1">Paste iframe atau URL Google Maps di sini.</p>
        </div>

        {{-- ===== CONTACT SETTINGS ===== --}}
        <div class="fs-card">
            <h2 class="fs-heading">Kontak</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="email" class="fs-input" placeholder="Email" wire:model.defer="email">
                <input type="text" class="fs-input" placeholder="Telepon" wire:model.defer="phone">
            </div>
        </div>

        {{-- ===== SOCIAL MEDIA ===== --}}
        <div class="fs-card">
            <h2 class="fs-heading">Media Sosial</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" class="fs-input" placeholder="Facebook" wire:model.defer="facebook">
                <input type="text" class="fs-input" placeholder="Instagram" wire:model.defer="instagram">
                <input type="text" class="fs-input" placeholder="Twitter" wire:model.defer="twitter">
            </div>
        </div>

        {{-- ===== LOGO & FAVICON ===== --}}
        <div class="fs-card">
            <h2 class="fs-heading">Logo & Favicon</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Logo --}}
                <div>
                    <label class="block font-medium text-sm mb-1">Logo Situs</label>
                    <input type="file" wire:model="logo" class="fs-input">
                    @if($logo)
                        <img src="{{ $logo instanceof \Livewire\TemporaryUploadedFile ? $logo->temporaryUrl() : asset('storage/'.$logo) }}"
                             class="fs-preview">
                    @endif
                    <p class="text-sm text-gray-500 mt-1">Max 1MB (.png/.jpg)</p>
                </div>

                {{-- Favicon --}}
                <div>
                    <label class="block font-medium text-sm mb-1">Favicon</label>
                    <input type="file" wire:model="favicon" class="fs-input">
                    @if($favicon)
                        <img src="{{ $favicon instanceof \Livewire\TemporaryUploadedFile ? $favicon->temporaryUrl() : asset('storage/'.$favicon) }}"
                             class="fs-preview">
                    @endif
                    <p class="text-sm text-gray-500 mt-1">Max 0.5MB (.ico/.png)</p>
                </div>
            </div>
        </div>

        {{-- ===== SUBMIT BUTTON ===== --}}
        <div class="mt-6">
            <button type="submit" class="fs-submit">
                Simpan Semua Settings
            </button>
            <p class="text-sm text-gray-500 mt-1">Pastikan semua data sudah benar sebelum disimpan.</p>
        </div>

    </form>
</x-filament::page>
