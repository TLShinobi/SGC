<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Archivo extends Model
{
    use HasFactory;

    protected $table = 'archivos';

    protected $fillable = [
        'registro_id',
        'url_recurso',
        'nombre_original',
        'tipo_archivo',
        'peso_archivo_kb',
    ];

    public function registro(): BelongsTo
    {
        return $this->belongsTo(RegistroPatrimonial::class, 'registro_id');
    }
}
