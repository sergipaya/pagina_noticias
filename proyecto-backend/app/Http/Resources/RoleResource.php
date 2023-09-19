<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="RoleResource",
 *     description="Role resource",
 *     @OA\Xml(name="RoleResource"),
 * )
 */
class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     *
     * @OA\Property(
     *     property="data",
     *     title="data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Models\Role[]
     */
    public function toArray(Request $request): array
    {
        $users = $this->users;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'users' => $users,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
