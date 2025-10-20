<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * listing gula already created users er modde distribute korbo
     * Note: This migration is mainly for updating existing data, not fresh installs
     */
    public function up(): void
    {
        // Get all host users
        $hostIds = DB::table('users')->where('role', 'host')->pluck('id')->toArray();

        // Only redistribute if we have hosts and listings
        if (empty($hostIds)) {
            return; // No hosts found, skip
        }

        // Get all listings
        $listings = DB::table('listings')->orderBy('id')->get();

        if ($listings->isEmpty()) {
            return; // No listings to redistribute
        }

        // round robin diye evenly distribution
        foreach ($listings as $index => $listing) {
            $hostIndex = $index % count($hostIds);
            $newOwnerId = $hostIds[$hostIndex];

            DB::table('listings')
                ->where('id', $listing->id)
                ->update(['owner_id' => $newOwnerId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert all listings back to first host user
        $firstHostId = DB::table('users')->where('role', 'host')->value('id');

        if ($firstHostId) {
            DB::table('listings')->update(['owner_id' => $firstHostId]);
        }
    }
};
