<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="UserResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="email", type="string"),
 *     @OA\Property(property="projects", type="array", @OA\Items(ref="#/components/schemas/ProjectResource")),
 *     @OA\Property(property="timesheets", type="array", @OA\Items(ref="#/components/schemas/TimesheetResource"))
 * )
 */
class UserResource extends JsonResource
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
            'full_name' => $this->full_name,
            'email' => $this->email,
            'projects' => ProjectResource::collection($this->whenLoaded('projects')),
            'timesheets' => TimesheetResource::collection($this->whenLoaded('timesheets')),
        ];
    }
}
