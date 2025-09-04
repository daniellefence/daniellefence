<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Tags\Tag;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view tags') || $user->can('manage tags');
    }

    public function view(User $user, Tag $tag): bool
    {
        return $user->can('view tags') || $user->can('manage tags');
    }

    public function create(User $user): bool
    {
        return $user->can('manage tags');
    }

    public function update(User $user, Tag $tag): bool
    {
        return $user->can('manage tags');
    }

    public function delete(User $user, Tag $tag): bool
    {
        return $user->can('manage tags');
    }
}
