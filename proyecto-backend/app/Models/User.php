<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="User"),
 * @OA\Property(property="name", type="string", description="Nombre del usuario", example="swaggerUser"),
 * @OA\Property(property="email", type="string", description="email del usuario",example="swaggerUser@email.com"),
 * @OA\Property(property="password", type="string", description="passord del usuario", example="12345678"),
 * )
 *
 * Class User
 *
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles() {
        return $this->belongsToMany('App\Models\Role');
    }

    public function news()
    {
        return $this->hasMany('App\Models\Article');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }
}
