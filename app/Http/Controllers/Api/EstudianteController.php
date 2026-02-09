<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
public function index() {
    // Esto carga la relación para que Vue reciba el objeto "curso"
    return Estudiante::with('curso')->get();
}
    public function store(Request $request)
{
    $validated = $request->validate([
        'nombre'   => 'required|string|max:255',
        'email'    => 'required|email|unique:estudiantes,email', // Importante
        'curso_id' => 'required|exists:cursos,id',
    ]);

    return Estudiante::create($validated);
}

    public function update(Request $request, Estudiante $estudiante)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:estudiantes,email,' . $estudiante->id,
            'curso_id' => 'required|exists:cursos,id'
        ]);

        $estudiante->update($request->all());

        return response()->json($estudiante);
    }

    public function destroy(Estudiante $estudiante)
    {
        $estudiante->delete();

        return response()->json(['mensaje' => 'Estudiante eliminado']);
    }
}
