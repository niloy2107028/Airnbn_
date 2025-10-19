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
     * Only update existing users' roles, don't create new users
     * (UserSeeder handles user creation)
     */
    public function up(): void
    {
        // Update existing users with roles if they exist (Bangladeshi names)
        DB::table('users')->where('username', 'niloy')->update(['role' => 'host']);
        DB::table('users')->where('username', 'rafiq')->update(['role' => 'host']);
        DB::table('users')->where('username', 'tasnim')->update(['role' => 'host']);
        DB::table('users')->where('username', 'karim')->update(['role' => 'host']);
        DB::table('users')->where('username', 'sadia')->update(['role' => 'host']);
        DB::table('users')->where('username', 'fahim')->update(['role' => 'host']);
        DB::table('users')->where('username', 'nusrat')->update(['role' => 'guest']);
        DB::table('users')->where('username', 'arif')->update(['role' => 'guest']);
        DB::table('users')->where('username', 'mim')->update(['role' => 'guest']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert all users to guest role
        DB::table('users')->update(['role' => 'guest']);

        // Optionally delete created guest users
        DB::table('users')->where('username', 'alice_guest')->delete();
        DB::table('users')->where('username', 'bob_guest')->delete();
    }
};
