<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('type')->default('berita')->after('slug'); 
            // type: 'berita' | 'pengumuman'
        });

        // set semua data lama jadi berita (aman)
        DB::table('articles')->whereNull('type')->update(['type' => 'berita']);
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
