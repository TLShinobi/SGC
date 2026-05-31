<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistroPatrimonial extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'registros_patrimoniales';

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_suceso',
        'url_recurso',
        'tipo_archivo',
        'peso_archivo_kb',
        'id_categoria',
        'created_by',
    ];

    protected $casts = [
        'fecha_suceso' => 'date',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function archivos()
    {
        return $this->hasMany(Archivo::class, 'registro_id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'registro_id');
    }

    public function marcadosPor()
    {
        return $this->belongsToMany(User::class, 'marcadores', 'registro_id', 'user_id')->withTimestamps();
    }
}
