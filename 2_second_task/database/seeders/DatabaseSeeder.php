<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create roles if they don't exist
        $superAdminRole = Role::firstOrCreate(['name' => 'admin']); // Super Admin
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Assign all permissions to Super Admin
        $allPermissions = Permission::pluck('name')->toArray();
        $superAdminRole->syncPermissions($allPermissions);

        // Create an admin user and assign the Super Admin role
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
            ]
        );
        $admin->assignRole($superAdminRole);

        // Create a normal user and assign role
        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Normal User',
                'password' => bcrypt('password'),
            ]
        );
        $user->assignRole($userRole);
    }
}
