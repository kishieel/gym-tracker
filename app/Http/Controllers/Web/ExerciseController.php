<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Enums\ExerciseType;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExerciseRequest;
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
        $leaders = $exercise->workouts()
            ->join('users', 'users.id', '=', 'workouts.user_id')
            ->groupBy('user_id')
            ->select(['first_name', 'last_name', 'nick_name']);

        $leaders = $exercise->type === ExerciseType::Incremental
            ? $leaders->selectRaw('sum(quantity) as summary')
            : $leaders->selectRaw('max(quantity) as summary');

        $leaders = $leaders->orderByDesc('summary')
            ->limit(5)
            ->get();

        $workouts = $exercise->workouts()
            ->join('users', 'users.id', '=', 'workouts.user_id')
            ->select(['workouts.id', 'user_id', 'quantity', 'workout_at', 'first_name', 'last_name', 'nick_name', 'workouts.deleted_at'])
            ->orderByDesc('workout_at')
            ->orderByDesc('workouts.id')
            ->when(auth()->user()->is_admin, fn ($query) => $query->withTrashed())
            ->paginate(10)
            ->fragment('history');

        return view('pages.exercises.show')
            ->with('exercise', $exercise)
            ->with('leaders', $leaders)
            ->with('workouts', $workouts);
    }

    /**
     * Show the form for creating a new workout.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('pages.exercises.create');
    }

    /**
     * Store a newly created workout in storage.
     *
     * @param \App\Http\Requests\ExerciseRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ExerciseRequest $request)
    {
        $exercise = new Exercise();

        $exercise->label = $request->input('label');
        $exercise->type = $request->input('type');
        $exercise->unit = $request->input('unit');
        $exercise->created_by = auth()->id();
        $exercise->save();

        return redirect()->route('exercises.show', ['exercise' => $exercise]);
    }

    /**
     * Show the form for editing the specified exercise.
     *
     * @param \App\Models\Exercise $exercise
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Exercise $exercise)
    {
        return view('pages.exercises.edit')
            ->with('exercise', $exercise);
    }

    /**
     * Update the specified exercise in storage.
     *
     * @param \App\Http\Requests\ExerciseRequest $request
     * @param \App\Models\Exercise $exercise
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ExerciseRequest $request, Exercise $exercise)
    {
        $exercise->update($request->validated());

        return redirect()->back()->with('status', trans('resources.exercise.update'));
    }

    /**
     * Restore the specified workout to storage.
     *
     * @param \App\Models\Exercise $exercise
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Exercise $exercise)
    {
        $exercise->restore();

        return redirect()->back();
    }

    /**
     * Remove the specified exercise from storage.
     *
     * @param \App\Models\Exercise $exercise
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Exercise $exercise)
    {
        $exercise->delete();

        return redirect()->back();
    }
}
