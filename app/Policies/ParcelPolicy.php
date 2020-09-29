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
        //
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
        //
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
     * @param  \App\Parcel  $parcel
     * @return mixed
     */
    public function update(User $user, Parcel $parcel)
    {
        //
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
        //
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
        //
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
        //
    }

    /**
     * Функция для проверки, может ли пользователь редактировать посылку, согласно статусу заказа
     * @param Parcel $parcel
     * @return bool
     */
    public function canEditByStatus(User $user, Parcel $parcel)
    {
        $allowedStatuses = [6];

        foreach ($allowedStatuses as $item) {
            if ((int)$parcel->status_id === (int)$item) {
                return true;
            }
        }

        return false;
    }
}
