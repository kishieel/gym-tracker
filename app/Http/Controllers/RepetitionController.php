<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RepetitionRequest;
use App\Models\Exercise;
use App\Models\Repetition;

class RepetitionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Repetition::class, 'repetition');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Exercise $exercise)
    {
        return view('pages.repetitions.create')
            ->with('exercise', $exercise);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(RepetitionRequest $request, Exercise $exercise)
    {
        $repetition = new Repetition();
        $repetition->user_id = auth()->user()->getAuthIdentifier();
        $repetition->exercise_id = $exercise->id;
        $repetition->quantity = $request->input('quantity');
        $repetition->workout_at = $request->date('workout_at');
        $repetition->save();

        return redirect()->route('exercises.show', ['exercise' => $exercise->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Exercise $exercise
     * @param Repetition $repetition
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Exercise $exercise, Repetition $repetition)
    {
        return view('pages.repetitions.edit')
            ->with('exercise', $exercise)
            ->with('repetition', $repetition);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Exercise $exercise
     * @param Repetition $repetition
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RepetitionRequest $request, Exercise $exercise, Repetition $repetition)
    {
        $repetition->update($request->validated());

        return redirect()->route('exercises.show', ['exercise' => $exercise->id]);
    }

    /**
     * Restore the specified repetition to storage.
     *
     * @param Exercise $exercise
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Exercise $exercise, Repetition $repetition)
    {
        $repetition->restore();

        return redirect()->back()->withFragment('history');
    }

    /**
     * Remove the specified repetition from storage.
     *
     * @param Exercise $exercise
     * @param Repetition $repetition
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Exercise $exercise, Repetition $repetition)
    {
        $repetition->delete();

        return redirect()->back()->withFragment('history');
    }
}
