<?php

namespace App\Policies;

use App\Parcel;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ParcelPolicy
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
        return $user->hasRole('superAdmin');
    }

    public function viewNew(User $user)
    {
        return $user->hasRole('superAdmin') ||
            $user->hasRole('manager');
    }

    public function viewMy(User $user)
    {
        return $user->hasRole('manager') ||
            $user->hasRole('client');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Parcel  $parcel
     * @return mixed
     */
    public function view(User $user, Parcel $parcel)
    {
        return $user->hasRole('superAdmin') ||
            ($user->hasRole('manager') && ((int)$user->id === (int)$parcel->manager_id || null === $parcel->manager_id)) ||
            (int)$user->id === (int)$parcel->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole('superAdmin') ||
            $user->hasRole('client');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Parcel  $parcel
     * @return mixed
     */
    public function update(User $user, Parcel $parcel)
    {
        return $user->hasRole('superAdmin') ||
            (int)$user->id === (int)$parcel->user_id;
    }

    public function accept(User $user)
    {
        return $user->hasRole('manager');
    }

    public function status(User $user)
    {
        return $user->hasRole('manager');
    }

    public function transfer(User $user)
    {
        return $user->hasRole('manager');
    }

    public function tracker(User $user)
    {
        return $user->hasRole('superAdmin') ||
            $user->hasRole('manager');
    }

    public function price(User $user)
    {
        return $user->hasRole('superAdmin') ||
            $user->hasRole('manager');
    }

    public function orderAddParcelID(User $user)
    {
        return $user->hasRole('superAdmin') ||
            $user->hasRole('client');
    }

    public function orderDeleteParcelID(User $user)
    {
        return $user->hasRole('superAdmin') ||
            $user->hasRole('client');
    }

    public function parcelSendToPackaging(User $user)
    {
        return $user->hasRole('superAdmin') ||
            $user->hasRole('client');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Parcel  $parcel
     * @return mixed
     */
    public function delete(User $user, Parcel $parcel)
    {
        return $user->hasRole('superAdmin') ||
            (int)$user->id === (int)$parcel->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Parcel  $parcel
     * @return mixed
     */
    public function restore(User $user, Parcel $parcel)
    {
        return $user->hasRole('superAdmin') ||
            (int)$user->id === (int)$parcel->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Parcel  $parcel
     * @return mixed
     */
    public function forceDelete(User $user, Parcel $parcel)
    {
        return $user->hasRole('superAdmin') ||
            (int)$user->id === (int)$parcel->user_id;
    }

    /**
     * Функция для проверки, может ли пользователь редактировать посылку, согласно статусу заказа
     * @param Parcel $parcel
     * @return bool
     */
    public function canEditByStatus(User $user, Parcel $parcel)
    {
        if ($user->hasRole('superAdmin')) {
            return true;
        }

        $allowedStatuses = [6];

        foreach ($allowedStatuses as $item) {
            if ((int)$parcel->status_id === (int)$item) {
                return true;
            }
        }

        return false;
    }
}
