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
    public string $twitter = '';

    // File uploads
    public $logo;
    public $favicon;

    // Maps
    public string $gmaps = '';

    // Override view
    public function getView(): string
    {
        return 'filament.pages.full-setting';
    }

    protected function rules(): array
    {
        return [
            'site_name'  => 'required|string|max:255',
            'tagline'    => 'nullable|string|max:255',
            'email'      => 'nullable|email|max:255',
            'phone'      => 'nullable|string|max:20',
            'facebook'   => 'nullable|string|max:255',
            'instagram'  => 'nullable|string|max:255',
            'twitter'    => 'nullable|string|max:255',
            'logo'       => 'nullable|image|max:1024',    // max 1MB
            'favicon'    => 'nullable|image|max:512',    // max 0.5MB
            'gmaps'      => 'nullable|string|max:500',
        ];
    }

    public function mount(): void
    {
        $fields = [
            'site_name', 'tagline', 'email', 'phone',
            'facebook', 'instagram', 'twitter', 'gmaps'
        ];

        foreach ($fields as $field) {
            $this->$field = $this->getValue($field);
        }

        // File uploads (logo & favicon)
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

        // Upload logo
        if ($this->logo instanceof \Livewire\TemporaryUploadedFile) {
            $logoPath = $this->logo->store('settings', 'public');
            $this->setValue('logo', $logoPath);
        }

        // Upload favicon
        if ($this->favicon instanceof \Livewire\TemporaryUploadedFile) {
            $faviconPath = $this->favicon->store('settings', 'public');
            $this->setValue('favicon', $faviconPath);
        }

        // General
        $this->setValue('site_name', $this->site_name);
        $this->setValue('tagline', $this->tagline);

        // Contact
        $this->setValue('email', $this->email, 'contact');
        $this->setValue('phone', $this->phone, 'contact');

        // Sosial media
        $this->setValue('facebook', $this->facebook, 'social');
        $this->setValue('instagram', $this->instagram, 'social');
        $this->setValue('twitter', $this->twitter, 'social');

        // Google Maps
        $this->setValue('gmaps', $this->gmaps, 'general');

        Notification::make()
            ->title('Settings berhasil disimpan')
            ->success()
            ->send();
    }
}
