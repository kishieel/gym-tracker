<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkoutRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'exercise_id' => 'required|exists:exercises,id',
            'quantity' => 'required|numeric|min:0',
            'workout_at' => 'required|date',
        ];
    }
}
