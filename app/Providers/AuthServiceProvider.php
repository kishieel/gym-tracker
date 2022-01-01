<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Exercise;
use App\Models\Workout;
use App\Policies\ExercisePolicy;
use App\Policies\WorkoutPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Workout::class => WorkoutPolicy::class,
        Exercise::class => ExercisePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
