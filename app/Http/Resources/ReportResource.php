<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Report",
 *     type="object",
 *     title="Report",
 *     @OA\Property(property="id", type="integer", example=101),
 *     @OA\Property(
 *         property="sender",
 *         ref="#/components/schemas/User"
 *     ),
 *     @OA\Property(property="report_type", type="string", example="report"),
 *     @OA\Property(property="report_content", type="string", example="Here is my completed task."),
 *     @OA\Property(property="report_at", type="string", format="date-time", example="2025-08-07T12:34:56Z")
 * )
 */
class ReportResource extends JsonResource
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
            'sender' => new UserResource($this->whenLoaded('sender')),
            'report_type' => $this->report_type,
            'report_content' => $this->report_content,
            'report_at' => $this->report_at,
        ];
    }
}
