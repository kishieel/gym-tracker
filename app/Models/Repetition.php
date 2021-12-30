<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Repetition.
 *
 * @property int $id
 * @property int $user_id
 * @property int $exercise_id
 * @property float $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $workout_at
 * @property-read \App\Models\Exercise $exercise
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Repetition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Repetition newQuery()
 * @method static \Illuminate\Database\Query\Builder|Repetition onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Repetition query()
 * @method static \Illuminate\Database\Eloquent\Builder|Repetition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repetition whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repetition whereExerciseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repetition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repetition whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repetition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repetition whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repetition whereWorkoutAt($value)
 * @method static \Illuminate\Database\Query\Builder|Repetition withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Repetition withoutTrashed()
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Repetition extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'quantity',
        'unit',
    ];

    protected $casts = [
        'workout_at' => 'datetime',
    ];

    public function exercise(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
