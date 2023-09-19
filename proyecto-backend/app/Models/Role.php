<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Role"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="name", type="string", description="Nombre del rol", example="admin"),
 * @OA\Property(property="users", type="string", description="Array de users con el rol", example=""),
 * @OA\Property(property="created_at", type="string", description="Fecha de creación", example="23-03-09 18:00:00"),
 * @OA\Property(property="updated_at", type="string", description="Fecha de modificación", example="23-03-09 18:30:00"),
 * )
 *
 * Class Role
 *
 */
class Role extends Model
{
    use HasFactory;

    public function users() {
        return $this->belongsToMany('App\Models\User');
    }
}
