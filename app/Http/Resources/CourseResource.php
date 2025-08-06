<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Course",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Life"),
 *     @OA\Property(property="description", type="string", example="What does it mean to be human"),
 *     @OA\Property(property="featured_image", type="string", example="courses/cover.jpg"),
 *     @OA\Property(property="status", type="string", example="draft"),
 *     @OA\Property(property="started_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="finished_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(
 *         property="user_status",
 *         type="object",
 *         @OA\Property(property="is_active", type="boolean", example=true),
 *         @OA\Property(property="assigned_at", type="string", format="date-time")
 *     ),
 *     @OA\Property(
 *         property="course_subjects",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/CourseSubject")
 *     )
 * )
 */
class CourseResource extends JsonResource
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
            'featured_image' => $this->featured_image,
            'status' => $this->status,
            'started_at' => $this->started_at,
            'finished_at' => $this->finished_at,
            'user_status' => $this->whenPivotLoaded('user_course', function () {
                return [
                    'is_active' => $this->pivot->is_active,
                    'assigned_at' => $this->pivot->assigned_at,
                ];
            }),
            'course_subjects' => CourseSubjectResource::collection($this->whenLoaded('courseSubjects')),
        ];
    }
}
