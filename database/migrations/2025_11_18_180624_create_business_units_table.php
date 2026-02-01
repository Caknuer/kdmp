<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('business_units', function (Blueprint $table) {
            $table->id();

            // Nama Unit Usaha
            $table->string('name');

            // Slug URL
            $table->string('slug')->unique();

            // Kategori Unit (Keuangan, Perdagangan, Produksi, Jasa)
            $table->string('category')->nullable();

            // Icon Unit (emoji atau kode)
            $table->string('icon')->nullable();

            // Thumbnail/Logo Unit
            $table->string('thumbnail')->nullable();

            // Deskripsi Unit
            $table->text('description')->nullable();

            // Contoh layanan (multi-line)
            $table->text('services')->nullable();

            // Status aktif/nonaktif
            $table->boolean('is_active')->default(true);

            // Urutan tampil di halaman publik
            $table->integer('order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_units');
    }
};
