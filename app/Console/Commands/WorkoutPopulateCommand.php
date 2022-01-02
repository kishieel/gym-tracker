<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Exercise;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Console\Command;

class WorkoutPopulateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populate:workout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Allows to create exercise workout from CLI.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $workout = new Workout();

        $userId = $this->askUser();
        if (! $userId) {
            $this->error('User with given identifier doesn\'t exists!');

            return 1;
        }

        $workout->user_id = $userId;

        $exerciseId = $this->askExercise();
        if (! $exerciseId) {
            $this->error('Exercise with given identifier doesn\'t exists!');

            return 1;
        }

        $workout->exercise_id = $exerciseId;

        $workout->quantity = $this->ask('Quantity');
        $workout->save();

        $this->info('Workout created successfully!');

        return 0;
    }

    public function askExercise()
    {
        $suggestions = Exercise::query()
            ->select('label')
            ->get()
            ->map(fn (Exercise $exercise) => strtolower($exercise->label))
            ->toArray();

        $exerciseId = $this->anticipate('Exercise label or identifier', $suggestions);

        $exercise = Exercise::query()
            ->orWhere('label', 'like', '%' . $exerciseId . '%')
            ->orWhere('id', $exerciseId)
            ->get();

        if ($exercise->count() === 0) {
            return null;
        }

        if ($exercise->count() > 1) {
            $exerciseId = $this->choice(
                'Multiple exercises found for a given identifier. Please choose one',
                $exercise->map(fn (Exercise $exercise) => $exercise->id . ') ' . $exercise->label . ' (' . $exercise->type . ')')->toArray(),
            );

            $exercise = Exercise::query()
                ->where('id', explode(') ', $exerciseId)[0])
                ->get();
        }

        return optional($exercise[0])->id;
    }

    public function askUser()
    {
        $suggestions = User::query()
            ->select('email')
            ->get()
            ->map(fn (User $user) => strtolower($user->email))
            ->toArray();

        $userId = $this->anticipate('User email or identifier', $suggestions);

        $user = User::query()
            ->orWhere('email', 'like', '%' . $userId . '%')
            ->orWhere('id', $userId)
            ->get();

        if ($user->count() === 0) {
            return null;
        }

        if ($user->count() > 1) {
            $userId = $this->choice(
                'Multiple users found for a given identifier. Please choose one',
                $user->map(fn (User $user) => $user->id . ') ' . $user->first_name . ' ' . $user->last_name . ' <' . $user->email . '>')->toArray(),
            );

            $user = User::query()
                ->where('id', explode(') ', $userId)[0])
                ->get();
        }

        return optional($user[0])->id;
    }
}
