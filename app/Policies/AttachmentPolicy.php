<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Attachment;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttachmentPolicy
{
    use HandlesAuthorization;

    protected function canView(User $user): bool
    {
        return $user->can('manage attachments') || $user->can('view attachments');
    }

    public function viewAny(User $user): bool
    {
        return $this->canView($user);
    }

    public function view(User $user, Attachment $record): bool
    {
        return $this->canView($user);
    }

    public function create(User $user): bool
    {
        return $user->can('manage attachments');
    }

    public function update(User $user, Attachment $record): bool
    {
        return $user->can('manage attachments');
    }

    public function delete(User $user, Attachment $record): bool
    {
        return $user->can('manage attachments');
    }
}
