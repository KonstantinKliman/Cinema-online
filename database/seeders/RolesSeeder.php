<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $permissions = Permission::all('name');
        $role = Role::create(['name' => RoleType::Administrator->name]);
        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission->name);
        }
        Role::create(['name' => RoleType::Moderator->name]);
        Role::create(['name' => RoleType::Uploader->name]);
        Role::create(['name' => RoleType::Verified->name]);
        Role::create(['name' => RoleType::User->name]);
    }
}
