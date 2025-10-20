<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/*
To replace one old column (listing_type) with three new columns listing_type_1, listing_type_2, listing_type_3 in the existing table.
*/

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            // Drop the old single listing_type column if it exists
            if (Schema::hasColumn('listings', 'listing_type')) {
                $table->dropColumn('listing_type');
            }

            // Add three new columns for multiple listing types
            if (!Schema::hasColumn('listings', 'listing_type_1')) {
                $table->string('listing_type_1')->nullable();
            }
            if (!Schema::hasColumn('listings', 'listing_type_2')) {
                $table->string('listing_type_2')->nullable();
            }
            if (!Schema::hasColumn('listings', 'listing_type_3')) {
                $table->string('listing_type_3')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            // Drop the three new columns
            $table->dropColumn(['listing_type_1', 'listing_type_2', 'listing_type_3']);

            // Restore the old single column
            $table->string('listing_type')->nullable();
        });
    }
};
