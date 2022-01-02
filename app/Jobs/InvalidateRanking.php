<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Exercise;
use App\Models\User;
use App\Models\Workout;
use App\Notifications\BrokenRecordNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class InvalidateRanking implements ShouldQueue
{
    use Dispatchable;

    /** @var Exercise */
    private Exercise $exercise;

    /** @var User */
    private User $user;

    /** @var float */
    private float $gain;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Exercise $exercise, float $gain)
    {
        $this->exercise = $exercise;
        $this->user = $user;
        $this->gain = $gain;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->gain <= 0) {
            return;
        }

        $previousRecord = Workout::query()
            ->where('user_id', $this->user->id)
            ->where('exercise_id', $this->exercise->id)
            ->sum('quantity');

        $currentRecord = $previousRecord + $this->gain;

        $beaten = User::query()
            ->join('workouts', 'workouts.user_id', '=', 'users.id')
            ->where('exercise_id', $this->exercise->id)
            ->where('user_id', '!=', $this->user->id)
            ->groupBy('user_id', 'exercise_id')
            ->havingRaw('sum(workouts.quantity) between ? and ?', [$previousRecord, $currentRecord])
            ->selectRaw('users.*')
            ->get();

        Notification::send($beaten, new BrokenRecordNotification(
            $this->exercise->label,
            $this->user->full_name,
            $currentRecord . ' ' . $this->exercise->unit
        ));
    }
}
