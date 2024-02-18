<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Movie;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)
            ->has(Profile::factory(1))
            ->create();
    }
}
