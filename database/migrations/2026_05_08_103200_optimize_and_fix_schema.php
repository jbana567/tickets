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
        // 1. Ensure agent_response is nullable and add indexes for performance
        Schema::table('tickets', function (Blueprint $table) {
            // Modify agent_response to be nullable if it's not already
            if (Schema::hasColumn('tickets', 'agent_response')) {
                $table->text('agent_response')->nullable()->change();
            } else {
                $table->text('agent_response')->nullable();
            }

            // Add indexes for performance optimization
            if (Schema::hasColumn('tickets', 'applicant_email')) {
                $table->index('applicant_email');
            }
            if (Schema::hasColumn('tickets', 'assigned_to')) {
                $table->index('assigned_to');
            }
            if (Schema::hasColumn('tickets', 'status')) {
                $table->index('status');
            }
        });

        // 2. Add indexes to applications table
        Schema::table('applications', function (Blueprint $table) {
            if (Schema::hasColumn('applications', 'email')) {
                $table->index('email');
            }
            if (Schema::hasColumn('applications', 'status')) {
                $table->index('status');
            }
        });
        
        // 3. Add index to notifications
        Schema::table('notifications', function (Blueprint $table) {
            if (Schema::hasColumn('notifications', 'user_email')) {
                $table->index('user_email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropIndex(['applicant_email']);
            $table->dropIndex(['assigned_to']);
            $table->dropIndex(['status']);
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->dropIndex(['email']);
            $table->dropIndex(['status']);
        });
        
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex(['user_email']);
        });
    }
};
