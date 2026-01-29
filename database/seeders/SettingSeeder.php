<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            ['key' => 'site_name', 'value' => 'KDMP Wonokerto', 'group' => 'footer'],
            ['key' => 'address', 'value' => 'Alamat belum diisi', 'group' => 'footer'],
            ['key' => 'footer_description', 'value' => 'Deskripsi footer...', 'group' => 'footer'],

            ['key' => 'email', 'value' => 'admin@email.com', 'group' => 'contact'],
            ['key' => 'phone', 'value' => '08xxxxxxxxxx', 'group' => 'contact'],

            ['key' => 'gmaps_url', 'value' => '', 'group' => 'footer'],
        ];

        foreach ($defaults as $item) {
            Setting::updateOrCreate(
                ['key' => $item['key']],
                ['value' => $item['value'], 'group' => $item['group']]
            );
        }
    }
}
