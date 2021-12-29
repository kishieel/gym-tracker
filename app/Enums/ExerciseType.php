<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Incremental()
 * @method static static Maximum()
 */
final class ExerciseType extends Enum
{
    const Incremental = 'incremental';
    const Maximum = 'maximum';
}
