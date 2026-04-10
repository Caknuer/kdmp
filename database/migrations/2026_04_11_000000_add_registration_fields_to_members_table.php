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
        Schema::table('members', function (Blueprint $table) {
            $table->string('email')->nullable()->unique()->after('nik');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('phone');
            $table->string('position')->nullable()->after('gender');
            $table->string('role')->nullable()->after('position');
            $table->string('job')->nullable()->after('role');
            $table->timestamp('registered_at')->useCurrent()->after('ktp_photo_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['email', 'gender', 'position', 'role', 'job', 'registered_at']);
        });
    }
};
