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

    <form wire:submit.prevent="save" class="space-y-6">

        {{-- ===== GENERAL ===== --}}
        <div class="fs-card">
            <h2 class="fs-heading">General</h2>

            <input type="text" class="fs-input" placeholder="Nama Situs"
                   wire:model.defer="site_name">

            <input type="text" class="fs-input" placeholder="Tagline"
                   wire:model.defer="tagline">

            <label class="block text-sm mt-3">Address</label>
            <input type="text" class="fs-input" placeholder="Address"
                   wire:model.defer="addresss">

            <label class="block text-sm mt-3">Google Maps</label>
            <textarea class="fs-textarea" rows="4"
                      wire:model.defer="gmaps"></textarea>
        </div>

        {{-- ===== CONTACT ===== --}}
        <div class="fs-card">
            <h2 class="fs-heading">Kontak</h2>

            <input type="email" class="fs-input" placeholder="Email"
                   wire:model.defer="email">

            <input type="text" class="fs-input" placeholder="Telepon"
                   wire:model.defer="phone">
        </div>

        {{-- ===== SOCIAL ===== --}}
        <div class="fs-card">
            <h2 class="fs-heading">Media Sosial</h2>

            <input type="text" class="fs-input" placeholder="Facebook"
                   wire:model.defer="facebook">

            <input type="text" class="fs-input" placeholder="Instagram"
                   wire:model.defer="instagram">

            <input type="text" class="fs-input" placeholder="Tiktok"
                   wire:model.defer="tiktok">
        </div>

        {{-- ===== LOGO & FAVICON ===== --}}
        <div class="fs-card">
            <h2 class="fs-heading">Logo & Favicon</h2>

            {{-- LOGO --}}
            <div class="mb-4">
                <label class="text-sm">Logo</label>
                <input type="file" wire:model="logoUpload">

                @if ($logoUpload)
                    <img src="{{ $logoUpload->temporaryUrl() }}" class="fs-preview">
                @elseif ($logo)
                    <img src="{{ asset('storage/'.$logo) }}" class="fs-preview">
                @endif
            </div>

            {{-- FAVICON --}}
            <div>
                <label class="text-sm">Favicon</label>
                <input type="file" wire:model="faviconUpload">

                @if ($faviconUpload)
                    <img src="{{ $faviconUpload->temporaryUrl() }}" class="fs-preview">
                @elseif ($favicon)
                    <img src="{{ asset('storage/'.$favicon) }}" class="fs-preview">
                @endif
            </div>
        </div>

        {{-- ===== SUBMIT ===== --}}
        <x-filament::button type="submit" class="mt-4">
            Simpan
        </x-filament::button>

    </form>
</x-filament::page>