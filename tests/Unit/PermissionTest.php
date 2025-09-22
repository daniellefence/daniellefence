<?php

namespace Tests\Unit;

use App\Models\User;
use App\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_permission()
    {
        $user = User::factory()->create();

        $result = $user->createPermission('TestPermission');

        $this->assertTrue($result);
        $this->assertTrue($user->hasPermission('TestPermission'));
    }

    public function test_user_cannot_create_duplicate_permission()
    {
        $user = User::factory()->create();

        $user->createPermission('TestPermission');
        $result = $user->createPermission('TestPermission');

        $this->assertFalse($result);
    }

    public function test_user_has_permission_check()
    {
        $user = User::factory()->create();

        $this->assertFalse($user->hasPermission('NonExistentPermission'));

        $user->createPermission('ExistingPermission');
        $this->assertTrue($user->hasPermission('ExistingPermission'));
    }

    public function test_super_user_functionality()
    {
        $regularUser = User::factory()->create();
        $superUser = User::factory()->create();
        $superUser->createPermission('SuperUser');

        $this->assertFalse($regularUser->isSuperUser());
        $this->assertTrue($superUser->isSuperUser());
    }

    public function test_permission_class_static_methods()
    {
        $user = User::factory()->create();
        $user->createPermission('StaticTestPermission');

        $hasPermission = Permission::userHasPermission($user->id, 'StaticTestPermission');
        $this->assertTrue($hasPermission);

        $doesNotHavePermission = Permission::userHasPermission($user->id, 'NonExistentPermission');
        $this->assertFalse($doesNotHavePermission);
    }

    public function test_user_permissions_list()
    {
        $user = User::factory()->create();
        $user->createPermission('Permission1');
        $user->createPermission('Permission2');
        $user->createPermission('Permission3');

        $permissions = $user->permissions;

        $this->assertCount(3, $permissions);
        $this->assertTrue($permissions->pluck('key')->contains('Permission1'));
        $this->assertTrue($permissions->pluck('key')->contains('Permission2'));
        $this->assertTrue($permissions->pluck('key')->contains('Permission3'));
    }

    public function test_permission_deletion()
    {
        $user = User::factory()->create();
        $user->createPermission('TemporaryPermission');

        $this->assertTrue($user->hasPermission('TemporaryPermission'));

        // Remove permission
        $user->permissions()->where('key', 'TemporaryPermission')->delete();

        // Refresh user model
        $user->refresh();
        $this->assertFalse($user->hasPermission('TemporaryPermission'));
    }
}