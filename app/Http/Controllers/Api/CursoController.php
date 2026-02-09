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
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string'
        ]);

        $curso = Curso::create($request->all());

        return response()->json($curso, 201);
    }

    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string'
        ]);

        $curso->update($request->all());

        return response()->json($curso);
    }

    public function destroy(Curso $curso)
    {
        $curso->delete();

        return response()->json(['mensaje' => 'Curso eliminado']);
    }
}
