<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
This migration is used to add two new columns to the existing listings table — and remove them if rolled back.
*/

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->integer('trending_points')->default(0)->after('geometry_coordinates');
            $table->string('listing_type')->nullable()->after('trending_points');
        });

        //  Adds a new column trending_points

        // Type: integer

        // Default value: 0

        // Placed after the column geometry_coordinates
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropColumn(['trending_points', 'listing_type']);
        });
    }
};
