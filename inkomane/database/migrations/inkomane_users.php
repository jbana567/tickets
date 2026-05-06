<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('inkomane_users', function (Blueprint $table) {
            $table->id();
            // Basic User Info
            $table->string('name');
            $table->string('email')->unique();
            $table->string('role')->default('Customer'); 
            $table->string('department')->nullable();
            
            // Ticket Application Data
            $table->string('category')->nullable();
            $table->string('subject')->nullable();
            $table->text('description')->nullable();
            
            // Admin/Status Tracking
            $table->enum('status', ['pending', 'confirmed'])->default('pending');
            $table->string('payment')->default('None');
            $table->integer('clickthrough')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('inkomane_users');
    }
};