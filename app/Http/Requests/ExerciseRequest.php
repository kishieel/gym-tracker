<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\ExerciseType;
use App\Enums\RepetitionUnit;
use Illuminate\Foundation\Http\FormRequest;

class ExerciseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'label' => ['required'],
            'type' => ['required', 'enum_value:' . ExerciseType::class],
            'unit' => ['required', 'enum_value:' . RepetitionUnit::class],
        ];
    }
}
