<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    private array $permissionsArray = [
        'user' => ['show ', 'add ', 'edit ', 'delete '],
        'profile' => ['show ', 'add ', 'edit ', 'delete '],
        'movie' => ['show ', 'add ', 'edit ', 'delete '],
        'review' => ['show ', 'add ', 'edit ', 'delete '],
        'genre' => ['show ', 'add ', 'edit ', 'delete '],
        'person' => ['show ', 'add ', 'edit ', 'delete '],
        'person role' => ['show ', 'add ', 'edit ', 'delete '],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->permissionsArray as $model => $permissions) {
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission . $model]);
            }
        }
    }
}
