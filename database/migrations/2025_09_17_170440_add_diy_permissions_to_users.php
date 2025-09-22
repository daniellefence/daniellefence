<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $diyPermissions = [
            'diyCreate',
            'diyRead',
            'diyUpdate',
            'diyDelete',
        ];

        // Add DIY permissions to all existing users who have all permissions (super users)
        $users = User::all();
        foreach ($users as $user) {
            // Check if user is a super user (has all other permissions)
            $permission = new \App\Permission();
            $allPermissions = $permission->getListOfPermissions();

            // Count non-DIY permissions the user should have
            $nonDiyPermissions = array_filter($allPermissions, function($perm) {
                return !str_starts_with($perm, 'diy');
            });

            // If user has most permissions, they're likely an admin
            $userPermissionCount = $user->permissions()->count();
            $expectedCount = count($nonDiyPermissions) - 4; // Subtract DIY permissions

            if ($userPermissionCount >= $expectedCount - 5) { // Allow some margin
                foreach ($diyPermissions as $permission) {
                    $user->permissions()->firstOrCreate([
                        'key' => $permission,
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove DIY permissions from all users
        \DB::table('permission_user')
            ->whereIn('key', ['diyCreate', 'diyRead', 'diyUpdate', 'diyDelete'])
            ->delete();
    }
};