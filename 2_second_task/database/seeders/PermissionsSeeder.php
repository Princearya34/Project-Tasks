<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // User Management
            'view user',
            'create user',
            'edit user',
            'delete user',
            'assign role to user',
            'assign project to user',

            // Project Management
            'view project',
            'create project',
            'edit project',
            'delete project',
            'assign user to project',

            // Task Management
            'view task',
            'create task',
            'edit task',
            'delete task',
            'assign task to user',

            // Role & Permission Management
            'view role',
            'create role',
            'edit role',
            'delete role',
            'assign permissions to role',
            'manage roles',

            // Dashboard & Settings
            'view dashboard',
            'manage settings',
            'manage permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        echo "✅ All permissions have been seeded successfully.\n";
    }
}
