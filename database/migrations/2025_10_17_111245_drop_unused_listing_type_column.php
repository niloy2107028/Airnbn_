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
        Schema::table('listings', function (Blueprint $table) {
            // Drop the unused listing_type column (we use listing_type_1, 2, 3 instead)
            if (Schema::hasColumn('listings', 'listing_type')) {
                $table->dropColumn('listing_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            // Restore the column if needed
            $table->string('listing_type')->nullable()->after('trending_points');
        });
    }
};
