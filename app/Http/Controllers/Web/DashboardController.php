<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\Workout;

class DashboardController extends Controller
{
    /**
     * Display an exercise category ranking.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function exercises()
    {
        $exercises = Exercise::query()
            ->with(
                'participants',
                fn ($query) => $query
                    ->join('exercises', 'exercises.id', '=', 'workouts.exercise_id')
                    ->select(['first_name', 'last_name', 'nick_name', 'label', 'type'])
                    ->selectRaw('sum(workouts.quantity) as summary')
                    ->selectRaw('max(workouts.quantity) as record')
                    ->selectRaw('max(workouts.workout_at) as last_workout_at')
                    ->whereNull('workouts.deleted_at')
                    ->groupBy('user_id', 'exercise_id')
                    ->orderByDesc(
                        Workout::query()
                            ->selectRaw('if(exercises.type = "incremental", sum(workouts.quantity), max(workouts.quantity))')
                            ->whereColumn('workouts.exercise_id', 'exercises.id')
                            ->whereColumn('workouts.user_id', 'users.id')
                    )
                    ->withCasts([
                        'last_workout_at' => 'datetime',
                    ])
            )
            ->when(auth()->user()->is_admin, fn ($query) => $query->withTrashed())
            // ->select(['id', 'label', 'type', 'unit'])
            ->get();

        return view('pages.dashboard')
            ->with('exercises', $exercises);
    }
}
