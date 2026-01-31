<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Cara paling aman lintas DB adalah update data saja dan biarkan default.
        // Tapi kalau MySQL dan mau bener-bener default, perlu doctrine/dbal atau raw SQL.
        // Untuk aman tanpa dependency, kita fokus konsistensi dari Filament form + logic query.
        
        // Optional: pastikan record tanpa published_at tidak dianggap published
        DB::table('articles')
            ->where('is_published', true)
            ->whereNull('published_at')
            ->update(['is_published' => false]);
    }

    public function down(): void
    {
        // tidak perlu
    }
};
