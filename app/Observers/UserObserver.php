<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Fingerprint;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // find first admin of the company
        $adminId = User::where('company_id', $user->company_id)
            ->whereHas('roles', fn ($q) => $q->where('name', 'admin'))
            ->value('id');

        Fingerprint::create([
            'user_id'          => $user->id,
            'company_id'       => $user->company_id,
            'enroll_fingerprint' => false,
            'created_by'       => $adminId ?? $user->id,
        ]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
