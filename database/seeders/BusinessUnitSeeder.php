<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusinessUnit;
use Illuminate\Support\Str;

class BusinessUnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            [
                'name' => 'Unit Simpan Pinjam',
                'category' => 'Keuangan',
                'icon' => 'heroicon-o-banknotes',
                'description' => 'Unit usaha koperasi yang melayani simpanan dan pinjaman anggota dengan prinsip kekeluargaan.',
                'services' => "Simpanan wajib & sukarela\nPinjaman anggota koperasi\nRekap tabungan dan angsuran",
                'order' => 1,
            ],
            [
                'name' => 'Unit Perdagangan & Minimarket',
                'category' => 'Perdagangan',
                'icon' => 'heroicon-o-shopping-cart',
                'description' => 'Unit usaha koperasi yang menyediakan kebutuhan pokok dan mendukung produk UMKM desa.',
                'services' => "Penjualan kebutuhan pokok\nPemasaran produk UMKM desa\nDistribusi barang koperasi",
                'order' => 2,
            ],
            [
                'name' => 'Unit Produksi & Pengolahan',
                'category' => 'Produksi',
                'icon' => 'heroicon-o-cog-6-tooth',
                'description' => 'Unit produksi koperasi untuk mengolah hasil tani atau produk lokal agar bernilai tambah.',
                'services' => "Pengolahan hasil tani lokal\nProduksi barang koperasi\nPeningkatan nilai tambah produk desa",
                'order' => 3,
            ],
            [
                'name' => 'Unit Jasa & Pelayanan',
                'category' => 'Jasa',
                'icon' => 'heroicon-o-briefcase',
                'description' => 'Unit jasa koperasi yang melayani kebutuhan anggota dan masyarakat desa.',
                'services' => "Layanan jasa koperasi\nDukungan usaha anggota\nPelayanan komunitas desa",
                'order' => 4,
            ],
        ];

        foreach ($units as $unit) {
            $slug = Str::slug($unit['name']);

            BusinessUnit::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $unit['name'],
                    'category' => $unit['category'],
                    'icon' => $unit['icon'],
                    'thumbnail' => null,
                    'description' => $unit['description'],
                    'services' => $unit['services'],
                    'is_active' => true,
                    'order' => $unit['order'],
                ]
            );
        }
    }
}
