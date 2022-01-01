<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('exercise_id');
            $table->float('quantity');
            $table->timestamp('workout_at');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('exercise_id', 'workouts_exercise_id_foreign')
                ->references('id')
                ->on('exercises')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('user_id', 'workouts_user_id_foreign')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workouts');
    }
}
