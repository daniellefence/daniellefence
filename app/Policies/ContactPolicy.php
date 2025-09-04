<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    protected function canView(User $user): bool
    {
        return $user->can('manage contacts') || $user->can('view contacts');
    }

    public function viewAny(User $user): bool
    {
        return $this->canView($user);
    }

    public function view(User $user, Contact $record): bool
    {
        return $this->canView($user);
    }

    public function create(User $user): bool
    {
        return $user->can('manage contacts');
    }

    public function update(User $user, Contact $record): bool
    {
        return $user->can('manage contacts');
    }

    public function delete(User $user, Contact $record): bool
    {
        return $user->can('manage contacts');
    }
}
