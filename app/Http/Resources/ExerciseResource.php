<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ExerciseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Exercise $exercise */
        $exercise = $this->resource;

        return [
            'id' => $exercise->id,
            'label' => $exercise->label,
            'type' => $exercise->type,
            'unit' => $exercise->unit,
            'participants' => $exercise->users->map(fn (User $user) => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'nick_name' => $user->nick_name,
                'quantity' => $user->pivot->quantity,
                'last_workout_at' => $user->pivot->created_at,
            ]),
        ];
    }
}
