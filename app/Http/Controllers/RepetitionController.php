<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RepetitionRequest;
use App\Models\Exercise;
use App\Models\Repetition;
use Illuminate\Http\Request;

class RepetitionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Exercise $exercise)
    {
        return view('pages.repetition.create')
            ->with('exercise', $exercise);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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

        return redirect()->route('dashboard.exercises');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
