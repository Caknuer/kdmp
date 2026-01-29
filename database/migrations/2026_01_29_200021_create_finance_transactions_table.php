<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finance_transactions', function (Blueprint $table) {
            $table->id();

            $table->date('date');
            $table->enum('type', ['income', 'expense']); // transparansi umum
            $table->string('category')->nullable();
            $table->string('description')->nullable();
            $table->decimal('amount', 15, 2);

            $table->timestamps();

            $table->index(['date', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finance_transactions');
    }
};
