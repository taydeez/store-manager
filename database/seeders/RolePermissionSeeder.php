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
        $manager = Role::create(['name' => 'manager', 'guard_name' => 'api']);
        $store_manager = Role::create(['name' => 'store_manager', 'guard_name' => 'api']);
        $seller = Role::create(['name' => 'seller', 'guard_name' => 'api']);


        Permission::create(['name' => 'view_dashboard', 'guard_name' => 'api']);

        Permission::create(['name' => 'add_books', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete_books', 'guard_name' => 'api']);
        Permission::create(['name' => 'list_all_books', 'guard_name' => 'api']);
        Permission::create(['name' => 'edit_books', 'guard_name' => 'api']);
        Permission::create(['name' => 'shelve_books', 'guard_name' => 'api']);

        Permission::create(['name' => 'manage_all_stock', 'guard_name' => 'api']);
        Permission::create(['name' => 'manage_store_stock', 'guard_name' => 'api']);

        Permission::create(['name' => 'add_stores', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete_stores', 'guard_name' => 'api']);
        Permission::create(['name' => 'list_all_stores', 'guard_name' => 'api']);
        Permission::create(['name' => 'edit_store', 'guard_name' => 'api']);
        Permission::create(['name' => 'update_inventory', 'guard_name' => 'api']);

        Permission::create(['name' => 'list_all_orders', 'guard_name' => 'api']);
        Permission::create(['name' => 'cancel_orders', 'guard_name' => 'api']);

        Permission::create(['name' => 'list_all_customers', 'guard_name' => 'api']);

        Permission::create(['name' => 'sell_books', 'guard_name' => 'api']);

        Permission::create(['name' => 'manage_users', 'guard_name' => 'api']);
        Permission::create(['name' => 'add_users', 'guard_name' => 'api']);
        Permission::create(['name' => 'list_all_users', 'guard_name' => 'api']);

        Permission::create(['name' => 'update_rbac', 'guard_name' => 'api']);
        Permission::create(['name' => 'list_all_rbac', 'guard_name' => 'api']);


// Assign permissions to roles
        $admin->givePermissionTo([
            'view_dashboard',
            'add_books',
            'delete_books',
            'list_all_books',
            'edit_books',
            'shelve_books',
            'manage_all_stock',
            'manage_store_stock',
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
            'list_all_users',
            'update_rbac',
            'list_all_rbac',
        ]);

        //assign permissions to manager
        $manager->givePermissionTo([
            'view_dashboard',
            'list_all_books',
            'list_all_stores',
            'manage_all_stock',
            'shelve_books',
            'update_inventory',
            'list_all_orders',
            'list_all_customers',
            'sell_books',
            'cancel_orders',
        ]);

        //assign permissions to manager
        $store_manager->givePermissionTo([
            'manage_store_stock',
            'update_inventory',
            'list_all_orders',
            'list_all_customers',
            'sell_books',
            'cancel_orders',
        ]);

        //assign permission to seller
        $seller->givePermissionTo([
            'sell_books',
            'cancel_orders',
        ]);

// Assign role to user
        $user_1 = User::find(1);
        $user_1->assignRole('admin');

        if (config('app.env') === 'local') {
            $user_2 = User::find(2);
            $user_2->assignRole('manager');

            $user_3 = User::find(3);
            $user_3->assignRole('store_manager');

            $user_4 = User::find(4);
            $user_4->assignRole('seller');
        }
    }
}
