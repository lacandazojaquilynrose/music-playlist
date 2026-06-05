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
    Schema::create('songs', function (Blueprint $table) {
        $table->id();
        // Foreign key linking the song to the users table
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('title');
        $table->string('artist');
        $table->string('album')->nullable();
        $table->string('duration')->nullable(); // e.g., "3:45"
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
