<?php

namespace Database\Seeders;

use App\Models\AboutPage;
use App\Models\OrganizationMember;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create About Page
        AboutPage::firstOrCreate([], [
            'profil_singkat' => 'KDMP Wonokerto adalah organisasi yang berkomitmen untuk kemajuan masyarakat melalui berbagai program pengembangan dan pemberdayaan ekonomi.',
            'visi' => 'Menjadi organisasi terdepan dalam pengembangan masyarakat dan pemberdayaan ekonomi di wilayah Wonokerto.',
            'misi' => [
                'Meningkatkan kesejahteraan masyarakat melalui program-program pengembangan',
                'Mengembangkan potensi ekonomi lokal dan UMKM',
                'Mendorong inovasi dan kreativitas dalam pembangunan masyarakat',
                'Membangun kemitraan yang kuat dengan berbagai stakeholder'
            ],
            'nilai' => [
                'Integritas',
                'Profesionalitas',
                'Inovasi',
                'Gotong Royong',
                'Transparansi'
            ]
        ]);

        // Create Organization Members
        $members = [
            [
                'name_p' => 'Ahmad Susanto',
                'role' => 'Ketua Umum',
                'type' => 'pengurus',
                'bio' => 'Berpengalaman dalam bidang pengembangan masyarakat selama 15 tahun.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name_p' => 'Siti Aminah',
                'role' => 'Sekretaris',
                'type' => 'pengurus',
                'bio' => 'Ahli dalam administrasi dan manajemen organisasi.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name_p' => 'Budi Santoso',
                'role' => 'Bendahara',
                'type' => 'pengurus',
                'bio' => 'Spesialis dalam pengelolaan keuangan dan akuntansi.',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name_p' => 'Dr. Ratna Sari',
                'role' => 'Ketua Dewan Pengawas',
                'type' => 'pengawas',
                'bio' => 'Doktor ekonomi dengan spesialisasi pengembangan daerah.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name_p' => 'Prof. Hendro Wibowo',
                'role' => 'Anggota Dewan Pengawas',
                'type' => 'pengawas',
                'bio' => 'Professor bidang sosial ekonomi dengan pengalaman internasional.',
                'order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($members as $member) {
            OrganizationMember::firstOrCreate(
                ['name_p' => $member['name_p']],
                $member
            );
        }
    }
}