<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
        'role',
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
        'password' => 'hashed',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'administrador';
    }

    public function isPublicador(): bool
    {
        return $this->role === 'publicador' || $this->isAdmin();
    }

    public function isUsuario(): bool
    {
        return $this->role === 'usuario';
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function marcadores()
    {
        return $this->belongsToMany(RegistroPatrimonial::class, 'marcadores', 'user_id', 'registro_id')->withTimestamps();
    }

    public function registrosCreados()
    {
        return $this->hasMany(RegistroPatrimonial::class, 'created_by');
    }
}
