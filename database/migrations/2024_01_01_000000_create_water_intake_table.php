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
        Schema::create('water_intake', function (Blueprint $table) {
            $table->id();
            $table->string('user_identifier')->default('default_user'); // For future multi-user support
            $table->integer('glasses_count')->default(0);
            $table->date('intake_date');
            $table->timestamps();
            
            // Unique constraint to ensure one record per user per day
            $table->unique(['user_identifier', 'intake_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('water_intake');
    }
};
