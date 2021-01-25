<?php

namespace App\Policies;

use App\Support;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupportPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Support  $support
     * @return mixed
     */
    public function view(User $user, Support $support)
    {
        return $user->hasRole('superAdmin') ||
            (int)$user->id === (int)$support->client_id ||
            (int)$user->id === (int)$support->manager_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Support  $support
     * @return mixed
     */
    public function update(User $user, Support $support)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Support  $support
     * @return mixed
     */
    public function delete(User $user, Support $support)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Support  $support
     * @return mixed
     */
    public function restore(User $user, Support $support)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Support  $support
     * @return mixed
     */
    public function forceDelete(User $user, Support $support)
    {
        //
    }
}
