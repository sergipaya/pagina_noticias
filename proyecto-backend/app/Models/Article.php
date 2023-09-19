<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Article"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="title", type="string", description="titulo de la noticia", example="Noticia 1"),
 * @OA\Property(property="description", type="string",
 *     description="Descripción de la noticia",
 *     example="Lorem ipsum dolor sit amet, consectetur adipiscing elit."),
 * @OA\Property(property="body", type="string", description="cuerpo de la noticia", example="Lorem ipsum..."),
 * @OA\Property(property="date", type="datetime", description="fecha de la noticia", example="2023-01-01 00:00"),
 * @OA\Property(property="url", type="text", description="url de la noticia", example="www.ecample.com"),
 * @OA\Property(property="image", type="string", description="nombre de la imagen de cabecera", example="1.jpg"),
 * @OA\Property(property="user_id", type="string", description="id del usuario que ha creado la noticia", example="1"),
 * @OA\Property(property="user_name", type="string",
 *     description="nombre del usuario que ha creado la noticia", example="admin"),
 * @OA\Property(property="categories", type="string",
 *     description="categorias a las que pertenece la noticia", example=""),
 * @OA\Property(property="created_at", type="string", description="Fecha de creación", example="23-03-09 18:00:00"),
 * @OA\Property(property="updated_at", type="string", description="Fecha de modificación", example="23-03-09 18:30:00"),
 * )
 *
 * Class Article
 *
 */
class Article extends Model
{
    use HasFactory;

    protected $table = 'news';

    public function categories() {
        return $this->belongsToMany('App\Models\Category');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }
}
