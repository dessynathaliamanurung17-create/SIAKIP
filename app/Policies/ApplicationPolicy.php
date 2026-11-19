<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ApplicationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Application $application): bool
    {
        return $user->isAdmin() || $user->mahasiswa?->nim === $application->mahasiswa_nim;
    }

    public function update(User $user, Application $application): bool
    {
        // mahasiswa hanya boleh mengubah miliknya sendiri dan selama masih draft
        return $user->mahasiswa?->nim === $application->mahasiswa_nim
            && $application->status === 'draft';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Application $application): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Application $application): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Application $application): bool
    {
        return false;
    }
}
