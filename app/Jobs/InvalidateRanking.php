<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\ExerciseType;
use App\Models\Exercise;
use App\Models\User;
use App\Models\Workout;
use App\Notifications\BrokenRecordNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;

class InvalidateRanking implements ShouldQueue
{
    use Dispatchable;

    /** @var Exercise */
    private Exercise $exercise;

    /** @var User */
    private User $champion;

    /** @var float */
    private float $previousQuantity;

    /** @var float */
    private float $currentQuantity;

    /** @var float */
    private float $previousRecord;

    /** @var float */
    private float $currentRecord;

    /** @var Collection */
    private Collection $losers;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Exercise $exercise, float $currentQuantity, float $previousQuantity = 0)
    {
        $this->exercise = $exercise;
        $this->champion = $user;
        $this->previousQuantity = $previousQuantity;
        $this->currentQuantity = $currentQuantity;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->previousQuantity - $this->currentQuantity >= 0) {
            return;
        }

        $this->setupRecordsRange();
        $this->fetchLosers(
            $this->previousRecord,
            $this->currentRecord,
        );
        $this->sendNotification(
            $this->losers,
            $this->exercise->label . ' (' . ucfirst($this->exercise->type) . ')',
            $this->champion->full_name,
            $this->currentRecord . ' ' . $this->exercise->unit
        );
    }

    /**
     * @return void
     */
    protected function setupRecordsRange(): void
    {
        $query = Workout::query()
            ->where('user_id', $this->champion->id)
            ->where('exercise_id', $this->exercise->id);

        if ($this->exercise->type === ExerciseType::Incremental) {
            $previousRecord = $query->sum('quantity');
            $currentRecord = $previousRecord + ($this->currentQuantity - $this->previousQuantity);
        } else {
            $previousRecord = $query->max('quantity') ?? 0;
            $currentRecord = $this->currentQuantity;
        }

        $this->previousRecord = (float) $previousRecord;
        $this->currentRecord = (float) $currentRecord;
    }

    /**
     * @param float $min
     * @param float $max
     * @return void
     */
    protected function fetchLosers(float $min, float $max): void
    {
        $query = User::query()
            ->join('workouts', 'workouts.user_id', '=', 'users.id')
            ->where('exercise_id', $this->exercise->id)
            ->where('user_id', '!=', $this->champion->id)
            ->groupBy('user_id', 'exercise_id')
            ->selectRaw('users.*');

        $query = $this->exercise->type === ExerciseType::Incremental
            ? $query->havingRaw('sum(workouts.quantity) between ? and ?', [$min, $max])
            : $query->havingRaw('max(workouts.quantity) between ? and ?', [$min, $max]);

        $this->losers = $query->get();
    }

    /**
     * @param Collection $losers
     * @param string $exercise
     * @param string $champion
     * @param string $record
     * @return void
     */
    protected function sendNotification(Collection $losers, string $exercise, string $champion, string $record): void
    {
        Notification::send(
            $losers,
            new BrokenRecordNotification(
                $exercise,
                $champion,
                $record
            )
        );
    }
}
