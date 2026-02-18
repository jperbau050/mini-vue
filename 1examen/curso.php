<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estudiante; 

class Curso extends Model
{
    protected $table = 'cursos'; 
    protected $fillable = ['nombre', 'descripcion', 'estado'];

    protected static function booted()
    {
        static::updated(function ($curso) {
            // Si el estado cambió y ya no es activo, desmatriculamos
            if ($curso->wasChanged('estado') && $curso->estado !== 'active') {
                Estudiante::where('curso_id', $curso->id)
                          ->update(['curso_id' => null]);
            }
        });
    }
}
