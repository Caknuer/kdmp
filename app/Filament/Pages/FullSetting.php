<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Setting;
use Filament\Notifications\Notification;
use BackedEnum; // Kalau mau pakai enum (opsional)
use UnitEnum; // Biasanya built-in PHP 8.1+
use Livewire\WithFileUploads;

class FullSetting extends Page
{
    use WithFileUploads;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-cog';
    // protected static BackedEnum|string|null $navigationGroup = 'Settings';
    protected static UnitEnum|string|null $navigationGroup = 'Settings';
    // protected static string $view = 'filament.pages.full-setting';
 // General
    public string $site_name = '';
    public string $tagline = '';

    // Contact
    public string $email = '';
    public string $phone = '';

    // Media sosial
    public string $facebook = '';
    public string $instagram = '';
    public string $tiktok = '';

    // Upload (Livewire)
    public $logoUpload;
    public $faviconUpload;

    // Path tersimpan
    public string $logo = '';
    public string $favicon = '';

    // Maps
    public string $gmaps = '';

    // FullSetting.php
    public string $address = '';
    public string $footer_description = ''; // opsional
    public string $website = '';

    // Override view
    public function getView(): string
    {
        return 'filament.pages.full-setting';
    }

    protected function rules(): array
    {
        return [
            'site_name'     => 'required|string|max:255',
            'tagline'       => 'nullable|string|max:255',
            'address'       => 'nullable|string|max:255',
            'email'         => 'nullable|email|max:255',
            'phone'         => 'nullable|string|max:20',
            'facebook'      => 'nullable|string|max:255',
            'instagram'     => 'nullable|string|max:255',
            'tiktok'        => 'nullable|string|max:255',
            'gmaps'         => 'nullable|string|max:500',

            // UPLOAD
            'logoUpload'    => 'nullable|image|max:1024',
            'faviconUpload' => 'nullable|image|max:512',
        ];
    }

    public function mount(): void
    {
         $fields = [
         'site_name', 'tagline', 'email', 'phone',
        'facebook', 'instagram', 'tiktok', 'gmaps',
        'address', 'footer_description', 'website'
    ];

    foreach ($fields as $field) {
        $this->$field = $this->getValue($field);
    }

    // Path saja, BUKAN upload
    $this->logo = $this->getValue('logo');
    $this->favicon = $this->getValue('favicon');
    }

    protected function getValue(string $key): string
    {
        return Setting::where('key', $key)->value('value') ?? '';
    }

    protected function setValue(string $key, $value, string $group = 'general'): void
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );
    }

    public function save(): void
    {
        $this->validate();

        if ($this->logoUpload) {
            $path = $this->logoUpload->store('logo', 'public');
            $this->setValue('logo', $path);
            $this->logo = $path;
        }

        if ($this->faviconUpload) {
            $path = $this->faviconUpload->store('favicon', 'public');
            $this->setValue('favicon', $path);
            $this->favicon = $path;
        }

        $this->setValue('site_name', $this->site_name);
        $this->setValue('tagline', $this->tagline);
        $this->setValue('email', $this->email, 'contact');
        $this->setValue('phone', $this->phone, 'contact');

        $this->setValue('facebook', $this->facebook, 'social');
        $this->setValue('instagram', $this->instagram, 'social');
        $this->setValue('tiktok', $this->tiktok, 'social');

        $this->setValue('gmaps', $this->gmaps);

        $this->setValue('address', $this->address, 'general');
        $this->setValue('footer_description', $this->footer_description, 'general');
        $this->setValue('website', $this->website, 'general');

        Notification::make()
            ->title('Settings berhasil disimpan')
            ->success()
            ->send();

        cache()->flush();
    }
}
