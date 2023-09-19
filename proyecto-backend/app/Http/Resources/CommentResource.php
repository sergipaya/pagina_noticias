<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="CommentResource",
 *     description="Comment resource",
 *     @OA\Xml(name="CommentResource"),
 * )
 */
class CommentResource extends JsonResource
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
     * @var \App\Models\Comment[]
     */
    public function toArray(Request $request): array
    {
        $user = $this->user;
        $article = $this->article;
        return [
            'id' => $this->id,
            'body' => $this->body,
            'user_status' => $this->user_status,
            'user' => $user ?? 'deleted',
            'article' => $article,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
