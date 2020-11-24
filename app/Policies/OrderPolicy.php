<?php

namespace App\Policies;

use App\Order;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
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
     * @param  \App\Order  $order
     * @return mixed
     */
    public function view(User $user, Order $order)
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
     * @param  \App\Order  $order
     * @return mixed
     */
    public function update(User $user, Order $order)
    {
        return (int)$user->id === (int)$order->user_id || $user->hasRole('superAdmin');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function delete(User $user, Order $order)
    {
        return (int)$user->id === (int)$order->user_id || $user->hasRole('superAdmin');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function restore(User $user, Order $order)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function forceDelete(User $user, Order $order)
    {
        //
    }

    /**
     * Функция для проверки, может ли пользователь редактировать заказ, согласно статусу заказа
     * @param Order $order
     * @return bool
     */
    public function canEditByStatus(User $user, Order $order)
    {
        if ($user->hasRole('superAdmin')) {
            return true;
        }

        $allowedStatuses = [1];

        foreach ($allowedStatuses as $item) {
            if ((int)$order->status_id === (int)$item && ($user->hasRole('superAdmin') || $user->hasRole('client'))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Функция на проверку поля isDeleted
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function canDelete(User $user, Order $order)
    {
        if ($user->hasRole('superAdmin')) {
            return true;
        }

        return !$order->isDeleted;
    }
}
