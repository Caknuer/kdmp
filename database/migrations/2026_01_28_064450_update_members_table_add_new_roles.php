<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Only modify role if column exists (to handle partial migrations)
            if (Schema::hasColumn('members', 'role')) {
                DB::statement("ALTER TABLE members MODIFY COLUMN role ENUM('platinum', 'premium') DEFAULT 'platinum'");
            }

            // Add new fields for simplified registration (only if registered_at exists)
            if (Schema::hasColumn('members', 'registered_at')) {
                if (!Schema::hasColumn('members', 'documents_uploaded')) {
                    $table->boolean('documents_uploaded')->default(false)->after('registered_at');
                }
                if (!Schema::hasColumn('members', 'documents_uploaded_at')) {
                    $table->timestamp('documents_uploaded_at')->nullable()->after('documents_uploaded');
                }
            }

            // Make some fields nullable for simplified registration
            if (Schema::hasColumn('members', 'address')) {
                DB::statement("ALTER TABLE members MODIFY COLUMN address TEXT NULL");
            }
            if (Schema::hasColumn('members', 'phone')) {
                DB::statement("ALTER TABLE members MODIFY COLUMN phone VARCHAR(30) NULL");
            }
            if (Schema::hasColumn('members', 'gender')) {
                DB::statement("ALTER TABLE members MODIFY COLUMN gender VARCHAR(255) NULL");
            }
            if (Schema::hasColumn('members', 'position')) {
                DB::statement("ALTER TABLE members MODIFY COLUMN position VARCHAR(255) NULL");
            }
            if (Schema::hasColumn('members', 'job')) {
                DB::statement("ALTER TABLE members MODIFY COLUMN job VARCHAR(255) NULL");
            }
            if (Schema::hasColumn('members', 'ktp_photo_path')) {
                DB::statement("ALTER TABLE members MODIFY COLUMN ktp_photo_path VARCHAR(255) NULL");
            }
            if (Schema::hasColumn('members', 'foto_3x4_path')) {
                DB::statement("ALTER TABLE members MODIFY COLUMN foto_3x4_path VARCHAR(255) NULL");
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Reverse role enum
            DB::statement("ALTER TABLE members MODIFY COLUMN role ENUM('pengawas', 'pengurus', 'anggota') DEFAULT 'anggota'");

            $table->dropColumn(['documents_uploaded', 'documents_uploaded_at']);

            // Make fields not nullable again
            DB::statement("ALTER TABLE members MODIFY COLUMN address TEXT NOT NULL");
            DB::statement("ALTER TABLE members MODIFY COLUMN phone VARCHAR(30) NOT NULL");
            DB::statement("ALTER TABLE members MODIFY COLUMN gender VARCHAR(255) NOT NULL");
            DB::statement("ALTER TABLE members MODIFY COLUMN position VARCHAR(255) NOT NULL");
            DB::statement("ALTER TABLE members MODIFY COLUMN job VARCHAR(255) NOT NULL");
            DB::statement("ALTER TABLE members MODIFY COLUMN ktp_photo_path VARCHAR(255) NOT NULL");
            DB::statement("ALTER TABLE members MODIFY COLUMN foto_3x4_path VARCHAR(255) NOT NULL");
        });
    }
};