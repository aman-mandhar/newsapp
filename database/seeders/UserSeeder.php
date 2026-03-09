<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure admin role exists
        $adminRole = DB::table('user_roles')->where('name', 'Admin')->first();
        $adminRoleId = $adminRole->id ?? 1;

        // Create Global Admin only if it doesn't exist
        $adminExists = DB::table('users')->where('mobile_number', '0000000000')->exists();
        if (!$adminExists) {
            DB::table('users')->insert([
                'name' => 'Global Admin',
                'mobile_number' => '0000000000',
                'email' => 'parthmultisolution@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Bharat*1947#'),
                'user_role_id' => $adminRoleId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create a few additional users
        for ($i = 0; $i < 5; $i++) {
            $phone = str_pad((string) random_int(1000000000, 9999999999), 10, '0', STR_PAD_LEFT);
            $email = 'user' . $i . '@example.com';

            // Skip if user already exists
            if (DB::table('users')->where('mobile_number', $phone)->orWhere('email', $email)->exists()) {
                continue;
            }

            DB::table('users')->insert([
                'name' => 'User ' . ($i + 1),
                'mobile_number' => $phone,
                'email' => $email,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'user_role_id' => 2, // subscriber
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
