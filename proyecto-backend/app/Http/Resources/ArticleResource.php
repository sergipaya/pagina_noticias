<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="ArticleResource",
 *     description="Article resource",
 *     @OA\Xml(name="ArticleResource"),
 * )
 */
class ArticleResource extends JsonResource
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
     * @var \App\Models\Article[]
     */
    public function toArray(Request $request): array
    {
        $user = $this->user;
        $categories = $this->categories;
        $comments = $this->comments;
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'body' => $this->body,
            'imageName' => $this->imageName ?? 'default.png',
	    'image' => $this->image,
            'url' => $this->url,
            'date' => $this->date,
            'user_id' =>$this->user_id,
            'user_name' => $user->name,
            'categories' => $categories,
            'comments' => $comments,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
