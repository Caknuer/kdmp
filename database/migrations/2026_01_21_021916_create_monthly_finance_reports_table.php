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
        Schema::create('monthly_finance_reports', function (Blueprint $table) {
            $table->id();
            $table->string('month'); // format: 2026-01
            $table->bigInteger('income')->default(0);
            $table->bigInteger('expense')->default(0);
            $table->bigInteger('balance')->default(0);
            $table->boolean('is_published')->default(false);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_finance_reports');
    }
};
