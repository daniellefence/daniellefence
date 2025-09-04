<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    protected function canView(User $user): bool
    {
        return $user->can('manage categories') || $user->can('view categories');
    }

    public function viewAny(User $user): bool
    {
        return $this->canView($user);
    }

    public function view(User $user, Category $record): bool
    {
        return $this->canView($user);
    }

    public function create(User $user): bool
    {
        return $user->can('manage categories');
    }

    public function update(User $user, Category $record): bool
    {
        return $user->can('manage categories');
    }

    public function delete(User $user, Category $record): bool
    {
        return $user->can('manage categories');
    }
}
