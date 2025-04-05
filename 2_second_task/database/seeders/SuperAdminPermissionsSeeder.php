<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdminPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Ensure the Super Admin role exists
        $superAdminRole = Role::firstOrCreate([
            'name' => 'admin', 
            'guard_name' => 'web'
        ]);

        // Define all necessary permissions related to users, projects, tasks, roles, and system management
        $permissions = [
            // User Management
            'create user', 'view user', 'edit user', 'delete user',
            'assign role to user',
            
            // Role Management
            'create role', 'view role', 'edit role', 'delete role',
            'assign permissions to role', 'manage roles', 'manage permissions',
            
            // Project Management
            'create project', 'view project', 'edit project', 'delete project',
            'assign project to user', 'assign user to project',
            
            // Task Management
            'create task', 'view task', 'edit task', 'delete task',
            'assign task to user',
            
            // General Management
            'view dashboard', 'manage settings'
        ];

        // Create and sync permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
        
        // Assign all permissions to Super Admin
        $superAdminRole->syncPermissions($permissions);

        echo "✅ Super Admin has been granted all permissions.\n";
    }
}
