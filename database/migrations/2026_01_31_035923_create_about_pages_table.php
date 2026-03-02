<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();
            $table->text('profil_singkat')->nullable();

            $table->text('visi')->nullable();
            $table->json('misi')->nullable(); // array string

            $table->json('nilai')->nullable(); // array: [{icon,title,desc}]
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_pages');
    }
};
