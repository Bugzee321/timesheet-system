<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="TimesheetResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="date", type="string"),
 *     @OA\Property(property="hours", type="number"),
 *     @OA\Property(property="task_name", type="string"),
 *     @OA\Property(property="project", ref="#/components/schemas/ProjectResource"),
 *     @OA\Property(property="user", ref="#/components/schemas/UserResource")
 * )
 */
class TimesheetResource extends JsonResource
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
            'date' => $this->date,
            'hours' => $this->hours,
            'task_name' => $this->task_name,
            'project' => new ProjectResource($this->whenLoaded('project')),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
