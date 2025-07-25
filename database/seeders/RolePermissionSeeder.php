<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;


class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
// Create roles and permissions
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'api']);
        $editor = Role::create(['name' => 'seller', 'guard_name' => 'api']);

        Permission::create(['name' => 'add books', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete books', 'guard_name' => 'api']);

// Assign permissions to roles
        $admin->givePermissionTo(['add books', 'delete books']);

// Assign role to user
        $user = User::find(1);
        $user->assignRole('admin');
    }
}
