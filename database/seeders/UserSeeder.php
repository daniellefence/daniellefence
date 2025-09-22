<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

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

            // Assign all permissions to the user using Spatie's method
            $user->givePermissionTo($permissions);
        }
    }
}
