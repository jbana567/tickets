<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use raw statement to ensure the column is VARCHAR and can hold 'rejected'
        // This avoids issues with ENUM constraints during migration
        DB::statement("ALTER TABLE applications MODIFY status VARCHAR(50) DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No easy way to know what it was before, but VARCHAR(255) is safe
        Schema::table('applications', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
        });
    }
};
