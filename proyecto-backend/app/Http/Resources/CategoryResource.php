<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="CategoryResource",
 *     description="Category resource",
 *     @OA\Xml(name="CategoryResource"),
 * )
 */
class CategoryResource extends JsonResource
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
     * @var \App\Models\Category[]
     */
    public function toArray(Request $request): array
    {
        $news = $this->news;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'news' => $news,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
