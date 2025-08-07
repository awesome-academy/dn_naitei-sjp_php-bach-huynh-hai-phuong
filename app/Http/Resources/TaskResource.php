<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Task",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=10),
 *     @OA\Property(property="title", type="string", example="Complete Essay"),
 *     @OA\Property(property="description", type="string", example="Write a 1000-word essay."),
 *     @OA\Property(
 *         property="user_status",
 *         type="object",
 *         @OA\Property(property="is_done", type="integer", example=0),
 *         @OA\Property(property="done_at", type="string", format="date-time", nullable=true)
 *     )
 * )
 */
class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'user_status' => $this->whenLoaded('users', function () {
                $pivot = $this->users->first()?->pivot;

                return $pivot ? [
                    'is_done' => $pivot->is_done,
                    'done_at' => $pivot->done_at,
                ] : null;
            })
        ];
    }
}
