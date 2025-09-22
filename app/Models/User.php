<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasRoles;
    use Notifiable;
    use SoftDeletes;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'title',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function careers()
    {
        return $this->hasMany(Career::class);
    }

    public function documentation()
    {
        return $this->hasMany(Documentation::class);
    }

    public function latestActivity()
    {
        $return = 'N/A';
        $activity = $this->activities()->orderBy('created_at', 'desc')->first();
        if ($activity) {
            $return = $activity->action.' '.$activity->model_class.' '.$activity->model_id;
        }

        return $return;
    }

    public function legacyPermissions()
    {
        return \Illuminate\Support\Facades\DB::table('legacy_permissions')
            ->where('user_id', $this->id)
            ->whereNull('deleted_at');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // Allow all authenticated users to access the panel
        // You can add more specific logic here if needed
        return true;
    }

    public function createPermission($key)
    {
        $permission = $this->legacyPermissions()->where('key', $key)->first();
        if (! $permission) {
            \Illuminate\Support\Facades\DB::table('legacy_permissions')->insert([
                'user_id' => $this->id,
                'key' => $key,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function deletePermission($key)
    {
        \Illuminate\Support\Facades\DB::table('legacy_permissions')
            ->where('user_id', $this->id)
            ->where('key', $key)
            ->update(['deleted_at' => now()]);
    }

    public function hasPermission($permission)
    {
        if (! is_array($permission)) {
            // First check Spatie permissions (new system)
            if ($this->can($permission)) {
                return true;
            }

            // Fall back to legacy permissions for backward compatibility
            $permissionModel = $this->legacyPermissions()->where('key', $permission)->first();
            if ($permissionModel) {
                return true;
            }

            return false;
        } else {
            foreach (danielle()->permissions() as $permission) {
                foreach ($permission['actions'] as $action) {
                    if (! $this->hasPermission($permission['category'].ucfirst($action))) {
                        return false;
                    }
                }
            }

            return true;
        }

    }

    public function canUpdateUser()
    {
        return $this->hasPermission('userUpdate');
    }

    public function canDeleteUser()
    {
        return $this->hasPermission('userDelete');
    }

    public function isSuperUser()
    {
        $permissions = permission()->getListOfPermissions();
        if ($this->legacyPermissions()->count() == count($permissions)) {
            return true;
        }

        return false;
    }
}
