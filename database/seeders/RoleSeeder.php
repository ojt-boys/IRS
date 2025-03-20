<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'branch']);
        Role::create(['name' => 'shoe-technician']);

        // Create permissions
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage branches']);
        Permission::create(['name' => 'view job orders']);
        Permission::create(['name' => 'create job orders']);
    }
}
