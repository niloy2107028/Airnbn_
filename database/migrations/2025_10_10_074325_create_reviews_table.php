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

            // Author foreign key )
            $table->foreignId('author_id')
                ->constrained('users')
                ->onDelete('cascade');

            /*
                foreignId('author_id') : creates a column to store the user (author) ID.

                constrained('users') : connects it to the id column in the users table.

                onDelete('cascade') : if the user is deleted, their reviews are also deleted.

                Similarly, listing_id links each review to a listing, and deleting a listing removes its related reviews.
            */

            // Listing foreign key 
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
