<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'administrator']);
        Role::create(['name' => 'moderator']);
        Role::create(['name' => 'uploader']);
        Role::create(['name' => 'verified']);
        Role::create(['name' => 'user']);
    }
}
