<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        return Curso::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:active,draft,archived',
        ]);

        $curso = Curso::create($validated);
        return response()->json($curso);
    }

    public function update(Request $request, $id)
    {
        $curso = Curso::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:active,draft,archived', 
        ]);

        $curso->update($validated);

        return response()->json($curso);
    }

    public function destroy(Curso $curso)
    {
        $curso->delete();

        return response()->json(['mensaje' => 'Curso eliminado']);
    }
}
