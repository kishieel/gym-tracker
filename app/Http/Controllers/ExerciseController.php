<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\ExerciseType;
use App\Models\Exercise;

class ExerciseController extends Controller
{
    /**
     * Display the specified exercise.
     *
     * @param \App\Models\Exercise $exercise
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Exercise $exercise)
    {
        $leaders = $exercise->repetitions()
            ->join('users', 'users.id', '=', 'repetitions.user_id')
            ->groupBy('user_id')
            ->select(['first_name', 'last_name', 'nick_name']);

        $leaders = $exercise->type === ExerciseType::Incremental
            ? $leaders->selectRaw('sum(quantity) as summary')
            : $leaders->selectRaw('max(quantity) as summary');

        $leaders = $leaders->orderByDesc('summary')
            ->limit(5)
            ->get();

        $repetitions = $exercise->repetitions()
            ->join('users', 'users.id', '=', 'repetitions.user_id')
            ->select(['repetitions.id', 'user_id', 'quantity', 'workout_at', 'first_name', 'last_name', 'nick_name', 'repetitions.deleted_at'])
            ->orderByDesc('workout_at')
            ->orderByDesc('repetitions.id')
            ->when(auth()->user()->is_admin, fn ($query) => $query->withTrashed())
            ->paginate(10)
            ->fragment('history');

        return view('pages.exercises.show')
            ->with('exercise', $exercise)
            ->with('leaders', $leaders)
            ->with('repetitions', $repetitions);
    }

    /**
     * Remove the specified exercise from storage.
     *
     * @param Exercise $exercise
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Exercise $exercise)
    {
        $exercise->delete();

        return redirect()->route('dashboard.exercises');
    }
}
