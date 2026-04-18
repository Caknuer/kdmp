<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use UnitEnum;

use Filament\Pages\Page;

use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

use Filament\Notifications\Notification;

use Filament\Schemas\Components\Section;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class FullSetting extends Page implements HasForms
{
    use InteractsWithForms;

    /** =========================
     *  Navigation Filament
     *  ========================= */
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static UnitEnum|string|null $navigationGroup = 'Settings';

    protected static ?string $title = 'Pengaturan Website';

    protected static ?int $navigationSort = 999;

    protected string $view = 'filament.pages.full-setting';

    /** =========================
     *  Form State
     *  ========================= */
    public ?array $data = [];

    /** =========================
     *  Register Form
     *  ========================= */
    protected function getForms(): array
    {
        return [
            'form',
        ];
    }

    /** =========================
     *  Load Data on Page Open
     *  ========================= */
    public function mount(): void
    {
        $this->form->fill($this->getStateFromDb());
    }

    /** =========================
     *  Form Schema (Filament v4)
     *  ========================= */
    public function form(Schema $form): Schema
    {
        return $form
            ->statePath('data')
            ->schema([

                /** =========================
                 * BRANDING
                 * ========================= */
                Section::make('Branding')
                    ->description('Atur nama website, logo navbar, dan favicon tab browser.')
                    ->schema([

                        TextInput::make('site_name')
                            ->label('Nama Website')
                            ->required()
                            ->maxLength(255),

                        FileUpload::make('site_logo')
                            ->label('Logo Navbar')
                            ->image()
                            ->disk('public')
                            ->directory('site')
                            ->imagePreviewHeight('80')
                            ->maxSize(2048)
                            ->helperText('PNG transparan disarankan.')
                            ->deletable(true),

                        FileUpload::make('site_favicon')
                            ->label('Favicon / Icon Tab')
                            ->disk('public')
                            ->directory('site')
                            ->acceptedFileTypes([
                                'image/png',
                                'image/x-icon',
                            ])
                            ->maxSize(1024)
                            ->helperText('Ukuran ideal: 32x32 atau 48x48.')
                            ->deletable(true),

                    ])
                    ->columns(2),

                /** =========================
                 * HERO BERANDA
                 * ========================= */
                Section::make('Hero Beranda')
                    ->description('Atur gambar dan teks yang tampil di halaman depan.')
                    ->schema([

                        FileUpload::make('hero_image')
                            ->label('Gambar Hero')
                            ->image()
                            ->disk('public')
                            ->directory('hero')
                            ->imagePreviewHeight('140')
                            ->maxSize(4096)
                            ->deletable(true),

                        TextInput::make('hero_badge')
                            ->label('Badge Hero')
                            ->maxLength(80)
                            ->placeholder('KDMP • Transparan • Profesional'),

                        TextInput::make('hero_title')
                            ->label('Judul Hero Baris 1')
                            ->maxLength(80),

                        TextInput::make('hero_subtitle')
                            ->label('Judul Hero Baris 2')
                            ->maxLength(80),

                        Textarea::make('hero_description')
                            ->label('Deskripsi Hero')
                            ->rows(3)
                            ->maxLength(500),

                    ])
                    ->columns(2),

                /** =========================
                 * FOOTER & KONTAK
                 * ========================= */
                Section::make('Footer & Kontak')
                    ->description('Informasi footer dan kontak KDMP.')
                    ->schema([

                        TextInput::make('address')
                            ->label('Alamat')
                            ->maxLength(255),

                        Textarea::make('footer_description')
                            ->label('Deskripsi Footer')
                            ->rows(3)
                            ->maxLength(500),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->maxLength(20),

                        TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->helperText('Nomor WhatsApp dengan kode negara, misalnya +6281xxxx')
                            ->maxLength(40),

                        TextInput::make('facebook')
                            ->label('Facebook URL')
                            ->maxLength(255),

                        TextInput::make('instagram')
                            ->label('Instagram URL')
                            ->maxLength(255),

                        TextInput::make('twitter')
                            ->label('Twitter URL')
                            ->maxLength(255),

                        TextInput::make('youtube')
                            ->label('YouTube URL')
                            ->maxLength(255),

                        TextInput::make('gmaps_url')
                            ->label('Link Google Maps')
                            ->helperText('Gunakan link google.com/maps, bukan maps.app.goo.gl')
                            ->maxLength(2000),

                    ])
                    ->columns(2),

            ]);
    }

    /** =========================
     * SAVE SETTINGS
     * ========================= */
    public function save(): void
    {
        $data = $this->form->getState();

        if (empty($data['site_name'])) {
            Notification::make()
                ->title('Nama Website wajib diisi')
                ->danger()
                ->send();
            return;
        }

        if (!empty($data['gmaps_url']) && !str_contains($data['gmaps_url'], 'google.com/maps')) {
            Notification::make()
                ->title('Link Google Maps tidak valid')
                ->body('Gunakan link versi google.com/maps')
                ->danger()
                ->send();
            return;
        }

        /** Branding */
        $this->setValue('site_name', $data['site_name'], 'branding');
        $this->setValue('site_logo', $data['site_logo'] ?? '', 'branding');
        $this->setValue('site_favicon', $data['site_favicon'] ?? '', 'branding');

        /** Hero */
        $this->setValue('hero_image', $data['hero_image'] ?? '', 'hero');
        $this->setValue('hero_badge', $data['hero_badge'] ?? '', 'hero');
        $this->setValue('hero_title', $data['hero_title'] ?? '', 'hero');
        $this->setValue('hero_subtitle', $data['hero_subtitle'] ?? '', 'hero');
        $this->setValue('hero_description', $data['hero_description'] ?? '', 'hero');

        /** Footer */
        $this->setValue('address', $data['address'] ?? '', 'footer');
        $this->setValue('footer_description', $data['footer_description'] ?? '', 'footer');

        /** Contact */
        $this->setValue('email', $data['email'] ?? '', 'contact');
        $this->setValue('phone', $data['phone'] ?? '', 'contact');
        $this->setValue('whatsapp', $data['whatsapp'] ?? '', 'contact');
        $this->setValue('facebook', $data['facebook'] ?? '', 'contact');
        $this->setValue('instagram', $data['instagram'] ?? '', 'contact');
        $this->setValue('twitter', $data['twitter'] ?? '', 'contact');
        $this->setValue('youtube', $data['youtube'] ?? '', 'contact');

        /** Maps */
        $this->setValue('gmaps_url', $data['gmaps_url'] ?? '', 'footer');

        cache()->flush();

        Notification::make()
            ->title('Settings berhasil disimpan!')
            ->success()
            ->send();
    }

    /** =========================
     * Load DB State
     * ========================= */
    private function getStateFromDb(): array
    {
        $rows = Setting::pluck('value', 'key')->toArray();

        return [
            'site_name' => $rows['site_name'] ?? 'KDMP Wonokerto',
            'site_logo' => $rows['site_logo'] ?? null,
            'site_favicon' => $rows['site_favicon'] ?? null,

            'hero_image' => $rows['hero_image'] ?? null,
            'hero_badge' => $rows['hero_badge'] ?? null,
            'hero_title' => $rows['hero_title'] ?? null,
            'hero_subtitle' => $rows['hero_subtitle'] ?? null,
            'hero_description' => $rows['hero_description'] ?? null,

            'address' => $rows['address'] ?? '',
            'footer_description' => $rows['footer_description'] ?? '',
            'email' => $rows['email'] ?? '',
            'phone' => $rows['phone'] ?? '',
            'whatsapp' => $rows['whatsapp'] ?? '',
            'facebook' => $rows['facebook'] ?? '',
            'instagram' => $rows['instagram'] ?? '',
            'twitter' => $rows['twitter'] ?? '',
            'youtube' => $rows['youtube'] ?? '',
            'gmaps_url' => $rows['gmaps_url'] ?? '',
        ];
    }

    /** =========================
     * Save to DB Helper
     * ========================= */
    private function setValue(string $key, mixed $value, string $group): void
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value ?? '', 'group' => $group]
        );
    }
}
