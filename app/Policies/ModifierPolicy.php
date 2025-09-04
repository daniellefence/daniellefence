<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Modifier;
use Illuminate\Auth\Access\HandlesAuthorization;

class ModifierPolicy
{
    use HandlesAuthorization;

    protected function canView(User $user): bool
    {
        return $user->can('manage modifiers') || $user->can('view modifiers');
    }

    public function viewAny(User $user): bool
    {
        return $this->canView($user);
    }

    public function view(User $user, Modifier $record): bool
    {
        return $this->canView($user);
    }

    public function create(User $user): bool
    {
        return $user->can('manage modifiers');
    }

    public function update(User $user, Modifier $record): bool
    {
        return $user->can('manage modifiers');
    }

    public function delete(User $user, Modifier $record): bool
    {
        return $user->can('manage modifiers');
    }
}
