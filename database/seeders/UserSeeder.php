<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $moderator = User::create([
            'email' => 'moderator@gmail.com',
            'name' => 'Moderator',
            'password' => Hash::make('root')
        ]);

        $moderator->assignRole('moderator');

        $uploader = User::create([
            'email' => 'uploader@gmail.com',
            'name' => 'Uploader',
            'password' => Hash::make('root')
        ]);

        $uploader->assignRole('uploader');

        $verified = User::create([
            'email' => 'verified@gmail.com',
            'name' => 'Verified',
            'password' => Hash::make('root')
        ]);

        $verified->assignRole('verified');

        $user = User::create([
            'email' => 'user@gmail.com',
            'name' => 'user',
            'password' => Hash::make('root')
        ]);

        $user->assignRole('user');

    }
}
