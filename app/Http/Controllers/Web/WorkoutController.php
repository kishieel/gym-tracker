<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkoutRequest;
use App\Jobs\InvalidateRanking;
use App\Models\Exercise;
use App\Models\Workout;

class WorkoutController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Workout::class, 'workout');
    }

    /**
     * Show the form for creating a new workout.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Exercise $exercise)
    {
        return view('pages.workouts.create')
            ->with('exercise', $exercise);
    }

    /**
     * Store a newly created workout in storage.
     *
     * @param \App\Http\Requests\WorkoutRequest $request
     * @param \App\Models\Exercise $exercise
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(WorkoutRequest $request, Exercise $exercise)
    {
        $user = auth()->user();
        $quantity = $request->input('quantity');
        InvalidateRanking::dispatchSync($user, $exercise, $quantity);

        $workout = new Workout();
        $workout->user_id = auth()->id();
        $workout->exercise_id = $exercise->id;
        $workout->quantity = $request->input('quantity');
        $workout->workout_at = $request->date('workout_at');
        $workout->save();

        return redirect()->route('exercises.show', ['exercise' => $exercise])
            ->with('status', trans('resources.workout.store'));
    }

    /**
     * Show the form for editing the specified workout.
     *
     * @param Exercise $exercise
     * @param Workout $workout
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Exercise $exercise, Workout $workout)
    {
        return view('pages.workouts.edit')
            ->with('exercise', $exercise)
            ->with('workout', $workout);
    }

    /**
     * Update the specified workout in storage.
     *
     * @param \App\Http\Requests\WorkoutRequest $request
     * @param \App\Models\Exercise $exercise
     * @param \App\Models\Workout $workout
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(WorkoutRequest $request, Exercise $exercise, Workout $workout)
    {
        $user = auth()->user();
        $newQuantity = $request->input('quantity');
        $oldQuantity = $workout->quantity;
        InvalidateRanking::dispatchSync($user, $exercise, $newQuantity, $oldQuantity);

        $workout->update($request->validated());

        return redirect()->route('workouts.edit', ['exercise' => $exercise, 'workout' => $workout])
            ->with('status', trans('resources.workout.update'));
    }

    /**
     * Restore the specified workout to storage.
     *
     * @param Exercise $exercise
     * @param Workout $workout
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Exercise $exercise, Workout $workout)
    {
        $workout->restore();

        return redirect()->back()->withFragment('history')
            ->with('status', trans('resources.workout.restore'));
    }

    /**
     * Remove the specified workout from storage.
     *
     * @param Exercise $exercise
     * @param Workout $workout
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Exercise $exercise, Workout $workout)
    {
        $workout->delete();

        return redirect()->back()->withFragment('history')
            ->with('status', trans('resources.workout.destroy'));
    }
}
