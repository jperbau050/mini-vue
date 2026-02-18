<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function index()
    {
        return Estudiante::with('curso')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'email' => 'required|email|unique:estudiantes,email',
            'curso_id' => 'required|exists:cursos,id',
        ]);

        $estudiante = Estudiante::create($validated);

        return $estudiante->load('curso');
    }

    public function update(Request $request, Estudiante $estudiante)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'email' => 'required|email|unique:estudiantes,email,' . $estudiante->id,
            'curso_id' => 'required|exists:cursos,id',
        ]);

        $estudiante->update($validated);

        return $estudiante->load('curso');
    }
    public function destroy(Estudiante $estudiante)
    {
        $estudiante->delete();

        return response()->json(['mensaje' => 'Estudiante eliminado']);
    }
    public function matricular(Request $request, Curso $curso)
    {
        if ($curso->estado !== 'active') {
            return response()->json(['error' => 'Solo puedes matricularte en cursos activos.'], 403);
        }

        $curso->estudiantes()->attach($request->estudiante_id);
        return response()->json(['message' => 'Matriculado con éxito']);
    }
}
