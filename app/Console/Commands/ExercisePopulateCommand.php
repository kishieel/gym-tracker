<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\ExerciseType;
use App\Enums\RepetitionUnit;
use App\Models\Exercise;
use Illuminate\Console\Command;

class ExercisePopulateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populate:exercise';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Allows to create exercise from CLI.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $exercise = new Exercise();
        $exercise->label = $this->ask('Label');

        $type = $this->choice('Type', ExerciseType::getKeys(), 0);
        $exercise->type = ExerciseType::coerce($type);

        $unit = $this->choice('Unit', RepetitionUnit::getKeys(), 0);
        $exercise->unit = RepetitionUnit::coerce($unit);

        $exercise->save();

        $this->info('Exercise created successfully!');

        return 0;
    }
}
