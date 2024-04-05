<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //User permissions
        Permission::create(['name' => 'show user']);
        Permission::create(['name' => 'add user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete user']);
        //Profile permissions
        Permission::create(['name' => 'show profile']);
        Permission::create(['name' => 'add profile']);
        Permission::create(['name' => 'edit profile']);
        Permission::create(['name' => 'delete profile']);
        //Movie permissions
        Permission::create(['name' => 'show movie']);
        Permission::create(['name' => 'add movie']);
        Permission::create(['name' => 'edit movie']);
        Permission::create(['name' => 'delete movie']);
        //Review permissions
        Permission::create(['name' => 'show review']);
        Permission::create(['name' => 'add review']);
        Permission::create(['name' => 'edit review']);
        Permission::create(['name' => 'delete review']);
        //Genre permissions
        Permission::create(['name' => 'show genre']);
        Permission::create(['name' => 'add genre']);
        Permission::create(['name' => 'edit genre']);
        Permission::create(['name' => 'delete genre']);
        //Person permissions
        Permission::create(['name' => 'show person']);
        Permission::create(['name' => 'add person']);
        Permission::create(['name' => 'edit person']);
        Permission::create(['name' => 'delete person']);
        //Person role permissions
        Permission::create(['name' => 'show person role']);
        Permission::create(['name' => 'add person role']);
        Permission::create(['name' => 'edit person role']);
        Permission::create(['name' => 'delete person role']);
    }
}
