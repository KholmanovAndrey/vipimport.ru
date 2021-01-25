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
     * @param  \App\Order  $order
     * @return mixed
     */
    public function view(User $user, Order $order)
    {
        return $user->hasRole('superAdmin') ||
            ($user->hasRole('manager') && ((int)$user->id === (int)$order->manager_id || null === $order->manager_id)) ||
            (int)$user->id === (int)$order->user_id;
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
     * @param  \App\Order  $order
     * @return mixed
     */
    public function update(User $user, Order $order)
    {
        return $user->hasRole('superAdmin') ||
            (int)$user->id === (int)$order->user_id;
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

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function delete(User $user, Order $order)
    {
        return $user->hasRole('superAdmin') ||
            (int)$user->id === (int)$order->user_id;
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
        return $user->hasRole('superAdmin') ||
            (int)$user->id === (int)$order->user_id;
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
        return $user->hasRole('superAdmin') ||
            (int)$user->id === (int)$order->user_id;
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
