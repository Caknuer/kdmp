<?php

namespace Database\Seeders;

// database/seeders/AboutPageSeeder.php
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\AboutPage;
use Illuminate\Database\Seeder;

class AboutPageSeeder extends Seeder
{
    public function run(): void
    {
        AboutPage::updateOrCreate(
            [
                'profil_singkat' => "Koperasi Desa Merah Putih (KDMP) merupakan ...",
                'visi' => "Menjadi koperasi desa yang mandiri, profesional, ...",
                'misi' => [
                    "Mengembangkan unit usaha berbasis potensi desa",
                    "Meningkatkan pendapatan dan kesejahteraan anggota",
                    "Mengelola koperasi secara transparan dan akuntabel",
                    "Mendukung pertumbuhan UMKM lokal",
                ],
                'nilai' => [
                    ['icon' => '🤝', 'title' => 'Gotong Royong', 'desc' => 'Menumbuhkan kerja sama demi kemajuan bersama.'],
                    ['icon' => '📊', 'title' => 'Transparansi', 'desc' => 'Pengelolaan keuangan yang terbuka dan dapat dipercaya.'],
                    ['icon' => '🚀', 'title' => 'Kemandirian', 'desc' => 'Mendorong desa agar mandiri secara ekonomi.'],
                    ['icon' => '🌱', 'title' => 'Keberlanjutan', 'desc' => 'Usaha berkelanjutan untuk generasi sekarang dan mendatang.'],
                ],
            ]
        );
    }
}
