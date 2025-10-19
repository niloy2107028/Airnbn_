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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->text('comment')->nullable();
            $table->integer('rating')->unsigned();
            
            // Author foreign key (equivalent to Node.js author ObjectId ref)
            $table->foreignId('author_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            // Listing foreign key (implicit in Mongo via parent doc reviews array)
            $table->foreignId('listing_id')
                  ->constrained('listings')
                  ->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
