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
        Schema::table('tickets', function (Blueprint $table) {
            if (!Schema::hasColumn('tickets', 'customer_feedback')) {
                $table->text('customer_feedback')->nullable();
            }
            if (!Schema::hasColumn('tickets', 'is_closed_by_customer')) {
                $table->boolean('is_closed_by_customer')->default(false);
            }
            if (!Schema::hasColumn('tickets', 'work_time_seconds')) {
                $table->integer('work_time_seconds')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn(['customer_feedback', 'is_closed_by_customer', 'work_time_seconds']);
        });
    }
};
