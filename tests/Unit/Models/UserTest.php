<?php

namespace Tests\Unit\Models;

use App\Models\Activity;
use App\Models\Blog;
use App\Models\Career;
use App\Models\Documentation;
use App\Models\User;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = new User();
    }

    /** @test */
    public function it_implements_filament_user_interface()
    {
        $this->assertInstanceOf(FilamentUser::class, $this->user);
    }

    /** @test */
    public function it_uses_expected_traits()
    {
        $expectedTraits = [
            HasApiTokens::class,
            HasProfilePhoto::class,
            HasRoles::class,
            SoftDeletes::class,
            TwoFactorAuthenticatable::class,
        ];

        $usedTraits = class_uses_recursive(User::class);

        foreach ($expectedTraits as $trait) {
            $this->assertContains($trait, $usedTraits);
        }
    }

    /** @test */
    public function it_has_correct_fillable_attributes()
    {
        $expectedFillable = ['name', 'email', 'password', 'title'];

        $this->assertEquals($expectedFillable, $this->user->getFillable());
    }

    /** @test */
    public function it_has_correct_hidden_attributes()
    {
        $expectedHidden = [
            'password',
            'remember_token',
            'two_factor_recovery_codes',
            'two_factor_secret',
        ];

        $this->assertEquals($expectedHidden, $this->user->getHidden());
    }

    /** @test */
    public function it_has_correct_appended_attributes()
    {
        $expectedAppends = ['profile_photo_url'];

        $this->assertEquals($expectedAppends, $this->user->getAppends());
    }

    /** @test */
    public function it_has_correct_casts()
    {
        $casts = $this->user->getCasts();

        $this->assertEquals('datetime', $casts['email_verified_at']);
        $this->assertEquals('hashed', $casts['password']);
    }

    /** @test */
    public function it_has_many_activities()
    {
        $user = User::factory()->create();
        $activity1 = Activity::factory()->create(['user_id' => $user->id]);
        $activity2 = Activity::factory()->create(['user_id' => $user->id]);

        $activities = $user->activities;

        $this->assertCount(2, $activities);
        $this->assertContains($activity1->id, $activities->pluck('id'));
        $this->assertContains($activity2->id, $activities->pluck('id'));
    }

    /** @test */
    public function it_has_many_blogs()
    {
        $user = User::factory()->create();
        $blog1 = Blog::factory()->create(['user_id' => $user->id]);
        $blog2 = Blog::factory()->create(['user_id' => $user->id]);

        $blogs = $user->blogs;

        $this->assertCount(2, $blogs);
        $this->assertContains($blog1->id, $blogs->pluck('id'));
        $this->assertContains($blog2->id, $blogs->pluck('id'));
    }

    /** @test */
    public function it_has_many_careers()
    {
        $user = User::factory()->create();
        $career1 = Career::factory()->create(['user_id' => $user->id]);
        $career2 = Career::factory()->create(['user_id' => $user->id]);

        $careers = $user->careers;

        $this->assertCount(2, $careers);
        $this->assertContains($career1->id, $careers->pluck('id'));
        $this->assertContains($career2->id, $careers->pluck('id'));
    }

    /** @test */
    public function latest_activity_returns_formatted_string_when_activity_exists()
    {
        $user = User::factory()->create();
        Activity::factory()->create([
            'user_id' => $user->id,
            'action' => 'created',
            'model_class' => 'Blog',
            'model_id' => 123,
            'created_at' => now()->subHour()
        ]);
        Activity::factory()->create([
            'user_id' => $user->id,
            'action' => 'updated',
            'model_class' => 'Product',
            'model_id' => 456,
            'created_at' => now()
        ]);

        $latestActivity = $user->latestActivity();

        $this->assertEquals('updated Product 456', $latestActivity);
    }

    /** @test */
    public function latest_activity_returns_na_when_no_activity_exists()
    {
        $user = User::factory()->create();

        $latestActivity = $user->latestActivity();

        $this->assertEquals('N/A', $latestActivity);
    }

    /** @test */
    public function can_access_panel_returns_true_for_authenticated_user()
    {
        $user = User::factory()->create();
        $panel = $this->createMock(Panel::class);

        $result = $user->canAccessPanel($panel);

        $this->assertTrue($result);
    }

    /** @test */
    public function it_creates_legacy_permission_when_not_exists()
    {
        $user = User::factory()->create();

        $user->createPermission('test_permission');

        $this->assertDatabaseHas('legacy_permissions', [
            'user_id' => $user->id,
            'key' => 'test_permission',
            'deleted_at' => null
        ]);
    }

    /** @test */
    public function it_does_not_duplicate_legacy_permission_when_exists()
    {
        $user = User::factory()->create();

        // Create permission first time
        DB::table('legacy_permissions')->insert([
            'user_id' => $user->id,
            'key' => 'test_permission',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Try to create again
        $user->createPermission('test_permission');

        $permissionCount = DB::table('legacy_permissions')
            ->where('user_id', $user->id)
            ->where('key', 'test_permission')
            ->whereNull('deleted_at')
            ->count();

        $this->assertEquals(1, $permissionCount);
    }

    /** @test */
    public function it_soft_deletes_legacy_permission()
    {
        $user = User::factory()->create();

        DB::table('legacy_permissions')->insert([
            'user_id' => $user->id,
            'key' => 'test_permission',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user->deletePermission('test_permission');

        $this->assertDatabaseHas('legacy_permissions', [
            'user_id' => $user->id,
            'key' => 'test_permission',
        ]);

        $permission = DB::table('legacy_permissions')
            ->where('user_id', $user->id)
            ->where('key', 'test_permission')
            ->first();

        $this->assertNotNull($permission->deleted_at);
    }

    /** @test */
    public function has_permission_returns_true_for_spatie_permission()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('test_permission');

        $result = $user->hasPermission('test_permission');

        $this->assertTrue($result);
    }

    /** @test */
    public function has_permission_returns_true_for_legacy_permission()
    {
        $user = User::factory()->create();

        DB::table('legacy_permissions')->insert([
            'user_id' => $user->id,
            'key' => 'test_permission',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $result = $user->hasPermission('test_permission');

        $this->assertTrue($result);
    }

    /** @test */
    public function has_permission_returns_false_when_permission_not_found()
    {
        $user = User::factory()->create();

        $result = $user->hasPermission('nonexistent_permission');

        $this->assertFalse($result);
    }

    /** @test */
    public function has_permission_returns_false_for_soft_deleted_legacy_permission()
    {
        $user = User::factory()->create();

        DB::table('legacy_permissions')->insert([
            'user_id' => $user->id,
            'key' => 'test_permission',
            'deleted_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $result = $user->hasPermission('test_permission');

        $this->assertFalse($result);
    }

    /** @test */
    public function can_update_user_checks_user_update_permission()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('userUpdate');

        $result = $user->canUpdateUser();

        $this->assertTrue($result);
    }

    /** @test */
    public function can_delete_user_checks_user_delete_permission()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('userDelete');

        $result = $user->canDeleteUser();

        $this->assertTrue($result);
    }

    /** @test */
    public function it_can_be_created_with_fillable_attributes()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'title' => 'Manager'
        ];

        $user = User::create($userData);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'title' => 'Manager'
        ]);
        $this->assertEquals($userData['name'], $user->name);
        $this->assertEquals($userData['email'], $user->email);
        $this->assertEquals($userData['title'], $user->title);
    }

    /** @test */
    public function password_is_hashed_when_created()
    {
        $user = User::factory()->create(['password' => 'plaintext']);

        $this->assertNotEquals('plaintext', $user->password);
        $this->assertTrue(password_verify('plaintext', $user->password));
    }

    /** @test */
    public function it_can_be_soft_deleted()
    {
        $user = User::factory()->create();
        $userId = $user->id;

        $user->delete();

        $this->assertSoftDeleted('users', ['id' => $userId]);
        $this->assertNotNull($user->fresh()->deleted_at);
    }

    /** @test */
    public function legacy_permissions_query_excludes_deleted_permissions()
    {
        $user = User::factory()->create();

        // Create active permission
        DB::table('legacy_permissions')->insert([
            'user_id' => $user->id,
            'key' => 'active_permission',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create deleted permission
        DB::table('legacy_permissions')->insert([
            'user_id' => $user->id,
            'key' => 'deleted_permission',
            'deleted_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $permissions = $user->legacyPermissions()->get();

        $this->assertCount(1, $permissions);
        $this->assertEquals('active_permission', $permissions->first()->key);
    }

    /** @test */
    public function legacy_permissions_query_filters_by_user()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        DB::table('legacy_permissions')->insert([
            'user_id' => $user1->id,
            'key' => 'user1_permission',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('legacy_permissions')->insert([
            'user_id' => $user2->id,
            'key' => 'user2_permission',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user1Permissions = $user1->legacyPermissions()->get();

        $this->assertCount(1, $user1Permissions);
        $this->assertEquals('user1_permission', $user1Permissions->first()->key);
    }

    /** @test */
    public function it_prioritizes_spatie_permissions_over_legacy()
    {
        $user = User::factory()->create();

        // Give Spatie permission
        $user->givePermissionTo('test_permission');

        // Also create legacy permission (should not be checked)
        DB::table('legacy_permissions')->insert([
            'user_id' => $user->id,
            'key' => 'test_permission',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $result = $user->hasPermission('test_permission');

        $this->assertTrue($result);
    }

    /** @test */
    public function documentation_relationship_works()
    {
        $user = User::factory()->create();
        $doc1 = Documentation::factory()->create(['user_id' => $user->id]);
        $doc2 = Documentation::factory()->create(['user_id' => $user->id]);

        $documentation = $user->documentation;

        $this->assertCount(2, $documentation);
        $this->assertContains($doc1->id, $documentation->pluck('id'));
        $this->assertContains($doc2->id, $documentation->pluck('id'));
    }
}