<?php

namespace App\Policies;

use App\Models\User;
use App\Models\QuoteRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuoteRequestPolicy
{
    use HandlesAuthorization;

    protected function canView(User $user): bool
    {
        return $user->can('manage quote requests') || $user->can('view quote requests');
    }

    public function viewAny(User $user): bool
    {
        return $this->canView($user);
    }

    public function view(User $user, QuoteRequest $record): bool
    {
        return $this->canView($user);
    }

    public function create(User $user): bool
    {
        return $user->can('manage quote requests');
    }

    public function update(User $user, QuoteRequest $record): bool
    {
        return $user->can('manage quote requests');
    }

    public function delete(User $user, QuoteRequest $record): bool
    {
        return $user->can('manage quote requests');
    }
}
