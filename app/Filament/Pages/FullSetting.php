<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use UnitEnum;

class FullSetting extends Page
{
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-cog';
    protected static UnitEnum|string|null $navigationGroup = 'Settings';

    // FOOTER ONLY
    public string $site_name = '';
    public string $address = '';
    public string $footer_description = '';
    public string $email = '';
    public string $phone = '';
    public string $gmaps_url = '';

    public function getView(): string
    {
        return 'filament.pages.full-setting';
    }

    protected function rules(): array
    {
        return [
            'site_name'          => 'required|string|max:255',
            'address'            => 'nullable|string|max:255',
            'footer_description' => 'nullable|string|max:500',
            'email'              => 'nullable|email|max:255',
            'phone'              => 'nullable|string|max:20',
            'gmaps_url'          => 'nullable|url|max:2000',
        ];
    }

    public function mount(): void
    {
        foreach (['site_name','address','footer_description','email','phone','gmaps_url'] as $field) {
            $this->$field = $this->getValue($field);
        }
    }

    protected function getValue(string $key): string
    {
        return Setting::where('key', $key)->value('value') ?? '';
    }

    protected function setValue(string $key, string $value, string $group = 'footer'): void
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );
    }

    public function save(): void
    {
        $this->validate();

        // Wajib link versi google.com/maps agar embed stabil
        if ($this->gmaps_url && !str_contains($this->gmaps_url, 'google.com/maps')) {
            $this->addError('gmaps_url', 'Gunakan link Google Maps versi google.com/maps (bukan maps.app.goo.gl). Buka Maps di browser → Bagikan → Salin link.');
            return;
        }

        $this->setValue('site_name', $this->site_name, 'footer');
        $this->setValue('address', $this->address, 'footer');
        $this->setValue('footer_description', $this->footer_description, 'footer');

        $this->setValue('email', $this->email, 'contact');
        $this->setValue('phone', $this->phone, 'contact');

        $this->setValue('gmaps_url', $this->gmaps_url, 'footer');

        Notification::make()
            ->title('Footer settings berhasil disimpan')
            ->success()
            ->send();

        cache()->flush();
    }
}
