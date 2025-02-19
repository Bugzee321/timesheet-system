<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ProjectResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="status", type="string"),
 *     @OA\Property(property="attributes", type="array", @OA\Items(ref="#/components/schemas/AttributeResource")),
 *     @OA\Property(property="timesheets", type="array", @OA\Items(ref="#/components/schemas/TimesheetResource")),
 *     @OA\Property(property="users", type="array", @OA\Items(ref="#/components/schemas/UserResource"))
 * )
 */
class ProjectResource extends JsonResource
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
            'name' => $this->name,
            'status' => $this->status,
            'attributes' => AttributeResource::collection($this->whenLoaded('attributes')),
            'timesheets' => TimesheetResource::collection($this->whenLoaded('timesheets')),
            'users' => new UserResource($this->whenLoaded('users')),
        ];
    }
}
