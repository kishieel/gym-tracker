<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExercisePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Exercise $exercise
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Exercise $exercise)
    {
        return ! $exercise->trashed() && ($user->is_admin || $exercise->created_by == $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Exercise $exercise
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Exercise $exercise)
    {
        return ! $exercise->trashed() && ($user->is_admin || $exercise->created_by == $user->id);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Exercise $exercise
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Exercise $exercise)
    {
        return $exercise->trashed() && $user->is_admin;
    }
}
