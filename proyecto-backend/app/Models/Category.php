<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Category"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="name", type="string", description="Nombre de la categoría", example="Portátiles"),
 * @OA\Property(property="description", type="string",
 *     description="Descripción de la categoría",example="Lorem ipsum dolor sit amet, consectetur adipiscing elit."),
 * @OA\Property(property="news", type="string",
 *     description="Array de artículos que contienen la categoría", example=""),
 * @OA\Property(property="created_at", type="string", description="Fecha de creación", example="23-03-09 18:00:00"),
 * @OA\Property(property="updated_at", type="string", description="Fecha de modificación", example="23-03-09 18:30:00"),
 * )
 *
 * Class Category
 *
 */
class Category extends Model
{
    use HasFactory;

    public function news() {
        return $this->belongsToMany('App\Models\Article');
    }
}
