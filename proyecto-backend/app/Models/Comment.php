<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Comment"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="body", type="string", description="Contenido del comentario", example="Loren ipsum..."),
 * @OA\Property(property="user_status", type="string", description="Estado del usuario",example="deleted"),
 * @OA\Property(property="user", type="string", description="Usuario que ha creado el comentario", example="admin"),
 * @OA\Property(property="article", type="string", description="Noticia a la que pertenece el comentario", example=""),
 * @OA\Property(property="created_at", type="string", description="Fecha de creación", example="23-03-09 18:00:00"),
 * @OA\Property(property="updated_at", type="string", description="Fecha de modificación", example="23-03-09 18:30:00"),
 * )
 *
 * Class Comment
 *
 */
class Comment extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function article(){
        return $this->belongsTo('App\Models\Article');
    }
}
