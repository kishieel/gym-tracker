<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Repetition;
use Illuminate\Http\Request;

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
                    ->join('exercises', 'exercises.id', '=', 'repetitions.exercise_id')
                    ->select(['first_name', 'last_name', 'nick_name', 'label', 'type'])
                    ->selectRaw('sum(repetitions.quantity) as summary')
                    ->selectRaw('max(repetitions.quantity) as record')
                    ->selectRaw('max(repetitions.workout_at) as last_workout_at')
                    ->whereNull('repetitions.deleted_at')
                    ->groupBy('user_id', 'exercise_id')
                    ->orderByDesc(
                        Repetition::query()
                            ->selectRaw('if(exercises.type = "incremental", sum(repetitions.quantity), max(repetitions.quantity))')
                            ->whereColumn('repetitions.exercise_id', 'exercises.id')
                            ->whereColumn('repetitions.user_id', 'users.id')
                    )
                    ->withCasts([
                        'last_workout_at' => 'datetime',
                    ])
            )
            ->select(['id', 'label', 'type', 'unit'])
            ->get();

        return view('pages.dashboard')
            ->with('exercises', $exercises);
    }

    // /**
    //  * Show the form for creating a new exercise category.
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function create(): \Illuminate\Http\JsonResponse
    // {
    //     return response()->json([]);
    // }
    //
    // /**
    //  * Store a newly created exercise category in storage.
    //  *
    //  * @param \Illuminate\Http\Request $request
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function store(Request $request): \Illuminate\Http\JsonResponse
    // {
    //     return response()->json([]);
    // }
    //
    // /**
    //  * Display the exercise category ranking.
    //  *
    //  * @param int $id
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function show(Exercise $exercise): \Illuminate\Http\JsonResponse
    // {
    //     return response()->json([]);
    // }
    //
    // /**
    //  * Show the form for editing the specified exercise category.
    //  *
    //  * @param int $id
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function edit($id): \Illuminate\Http\JsonResponse
    // {
    //     return response()->json([]);
    // }
    //
    // /**
    //  * Update the specified exercise category in storage.
    //  *
    //  * @param \Illuminate\Http\Request $request
    //  * @param int $id
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    // {
    //     return response()->json([]);
    // }
    //
    // /**
    //  * Remove the specified exercise category from storage.
    //  *
    //  * @param int $id
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function destroy(Exercise $exercise): \Illuminate\Http\JsonResponse
    // {
    //     return response()->json([]);
    // }
}
