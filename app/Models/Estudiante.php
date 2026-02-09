<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    // ESTO ES LO QUE TE FALTA:
    protected $fillable = ['nombre', 'email', 'curso_id'];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}