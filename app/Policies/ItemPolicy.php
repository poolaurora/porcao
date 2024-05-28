<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ItemPolicy
{
        public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Item $item)
    {
        return $user->id === $item->user_id;
    }

    public function update(User $user, Item $item)
    {
        return $user->id === $item->user_id;
    }

    public function delete(User $user, Item $item)
    {
        return $user->id === $item->user_id;
    }


    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Item $item): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Item $item): bool
    {
        //
    }
}
