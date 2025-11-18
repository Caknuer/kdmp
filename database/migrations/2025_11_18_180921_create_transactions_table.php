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
        Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->date('date');
        $table->enum('type', ['income', 'expense']);    // pemasukan / pengeluaran
        $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade');
        $table->decimal('amount', 15, 2);               // angka besar aman
        $table->text('description')->nullable();
        $table->string('proof')->nullable();            // upload bukti
        $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
