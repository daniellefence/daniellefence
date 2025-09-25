<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = permission()->getListOfPermissions();

        // First create all permissions if they don't exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        // Then create users and assign permissions
        foreach (seeds()->users() as $data) {
            $user = User::firstOrCreate($data);

            // Special handling for Shane Barron - assign SuperAdmin role
            if ($user->email === 'sbarron@daniellefence.net') {
                // Ensure SuperAdmin role exists
                $superAdminRole = Role::firstOrCreate(['name' => 'SuperAdmin']);

                // Assign all permissions to SuperAdmin role if not already done
                if ($superAdminRole->permissions()->count() === 0) {
                    $superAdminRole->givePermissionTo($permissions);
                }

                // Assign SuperAdmin role to Shane
                $user->assignRole($superAdminRole);
            } else {
                // Assign all permissions to other users using Spatie's method
                $user->givePermissionTo($permissions);
            }
        }
    }
}
