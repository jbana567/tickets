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
        Schema::create('thank_yous', function (Blueprint $table) {
            $table->id();
            
            // The ticket this thank-you belongs to
            $table->foreignId('ticket_id')->constrained()->cascadeOnDelete();
            
            // The customer who sent the thank-you
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // The agent who received the thank-you
            $table->foreignId('agent_id')->constrained('users')->cascadeOnDelete();
            
            // Optional message from the customer
            $table->text('message')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thank_yous');
    }
};