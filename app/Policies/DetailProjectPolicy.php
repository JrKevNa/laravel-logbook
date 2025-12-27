<?php

namespace App\Policies;

use App\Models\DetailProject;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DetailProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DetailProject $detailProject): bool
    {
        //
        return $user->company_id === $detailProject->company_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->hasRole('user');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DetailProject $detailProject): bool
    {
        //
        return $user->company_id === $detailProject->company_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DetailProject $detailProject): bool
    {
        //
        return $user->company_id === $detailProject->company_id;
    }

    /**
     * Determine whether the user can mark finish the model.
     */
    public function finish(User $user, DetailProject $detailProject): bool
    {
        return $user->company_id === $detailProject->company_id
            && ! $detailProject->is_done;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DetailProject $detailProject): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DetailProject $detailProject): bool
    {
        //
    }
}
