<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update users table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('Customer');
            }
            if (!Schema::hasColumn('users', 'department')) {
                $table->string('department')->nullable();
            }
            if (!Schema::hasColumn('users', 'payment')) {
                $table->string('payment')->default('None');
            }
            if (!Schema::hasColumn('users', 'clickthrough')) {
                $table->integer('clickthrough')->default(0);
            }
        });

        // Update tickets table
        Schema::table('tickets', function (Blueprint $table) {
            if (!Schema::hasColumn('tickets', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('tickets', 'assigned_to')) {
                $table->string('assigned_to')->nullable();
            }
            if (!Schema::hasColumn('tickets', 'applicant_email')) {
                $table->string('applicant_email')->nullable();
            }
            if (!Schema::hasColumn('tickets', 'file_path')) {
                $table->string('file_path')->nullable();
            }
        });

        // Create applications table if it doesn't exist
        if (!Schema::hasTable('applications')) {
            Schema::create('applications', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email');
                $table->string('department')->nullable();
                $table->string('category')->nullable();
                $table->string('subject')->nullable();
                $table->text('description')->nullable();
                $table->string('status')->default('pending');
                $table->string('file_path')->nullable();
                $table->timestamp('submitted_at')->nullable();
                $table->timestamps();
            });
        }

        // Create notifications table
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('user_email');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
