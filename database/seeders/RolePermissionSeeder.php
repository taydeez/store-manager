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


        Permission::create(['name' => 'view_dashboard', 'guard_name' => 'api']);

        Permission::create(['name' => 'add_books', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete_books', 'guard_name' => 'api']);
        Permission::create(['name' => 'list_all_books', 'guard_name' => 'api']);
        Permission::create(['name' => 'edit_books', 'guard_name' => 'api']);

        Permission::create(['name' => 'add_stores', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete_stores', 'guard_name' => 'api']);
        Permission::create(['name' => 'list_all_stores', 'guard_name' => 'api']);
        Permission::create(['name' => 'edit_store', 'guard_name' => 'api']);
        Permission::create(['name' => 'update_inventory', 'guard_name' => 'api']);

        Permission::create(['name' => 'list_all_orders', 'guard_name' => 'api']);

        Permission::create(['name' => 'list_all_customers', 'guard_name' => 'api']);

        Permission::create(['name' => 'sell_books', 'guard_name' => 'api']);

        Permission::create(['name' => 'manage_users', 'guard_name' => 'api']);
        Permission::create(['name' => 'add_users', 'guard_name' => 'api']);
        Permission::create(['name' => 'list_users', 'guard_name' => 'api']);

        Permission::create(['name' => 'update_rbac', 'guard_name' => 'api']);


// Assign permissions to roles
        $admin->givePermissionTo([
            'view_dashboard',
            'add_books',
            'delete_books',
            'list_all_books',
            'edit_books',
            'add_stores',
            'delete_stores',
            'list_all_stores',
            'edit_store',
            'update_inventory',
            'list_all_orders',
            'list_all_customers',
            'sell_books',
            'manage_users',
            'add_users',
            'list_users',
            'update_rbac',
        ]);

// Assign role to user
        $user = User::find(1);
        $user->assignRole('admin');
    }
}
