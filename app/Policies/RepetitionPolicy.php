<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Repetition;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RepetitionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Repetition  $repetition
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Repetition $repetition)
    {
        return $repetition->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Repetition  $repetition
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Repetition $repetition)
    {
        return $repetition->user_id == $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Repetition  $repetition
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Repetition $repetition)
    {
        return false;
    }
}
