<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CursoController;
use App\Http\Controllers\Api\EstudianteController;

Route::apiResource('cursos', CursoController::class);
Route::apiResource('estudiantes', EstudianteController::class);
