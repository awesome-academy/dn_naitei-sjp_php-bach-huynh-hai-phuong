<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CourseSubject",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=5),
 *     @OA\Property(property="status", type="string", example="not_started"),
 *     @OA\Property(property="started_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="finished_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="estimated_duration_days", type="integer", example=3),
 *     @OA\Property(
 *         property="user_status",
 *         type="object",
 *         @OA\Property(property="status", type="string", example="not_started"),
 *         @OA\Property(property="started_at", type="string", format="date-time", nullable=true),
 *         @OA\Property(property="finished_at", type="string", format="date-time", nullable=true)
 *     ),
 *     @OA\Property(
 *         property="subject",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="title", type="string", example="Philosophy"),
 *         @OA\Property(property="description", type="string", example="Explore human nature.")
 *     ),
 *     @OA\Property(
 *         property="tasks",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Task")
 *     )
 * )
 */
class CourseSubjectResource extends JsonResource
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
            'status' => $this->status,
            'started_at' => $this->started_at,
            'finished_at' => $this->finished_at,
            'estimated_duration_days' => $this->estimated_duration_days,
            'user_status' => $this->whenLoaded('users', function () {
                $pivot = $this->users->first()?->pivot;

                return $pivot ? [
                    'status' => $pivot->status,
                    'started_at' => $pivot->started_at,
                    'finished_at' => $pivot->finished_at,
                ] : null;
            }),
            'subject' => $this->whenLoaded('subject', function () {
                return [
                    'id' => $this->subject->id,
                    'title' => $this->subject->title,
                    'description' => $this->subject->description,
                ];
            }),
            'tasks' => TaskResource::collection($this->whenLoaded('tasks')),
        ];
    }
}
