<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    protected function canView(User $user): bool
    {
        return $user->can('manage products') || $user->can('view products');
    }

    public function viewAny(User $user): bool
    {
        return $this->canView($user);
    }

    public function view(User $user, Product $record): bool
    {
        return $this->canView($user);
    }

    public function create(User $user): bool
    {
        return $user->can('manage products');
    }

    public function update(User $user, Product $record): bool
    {
        return $user->can('manage products');
    }

    public function delete(User $user, Product $record): bool
    {
        return $user->can('manage products');
    }
}
