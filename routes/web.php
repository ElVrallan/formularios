<?php

use App\Http\Controllers\FormularioController;
use Illuminate\Support\Facades\Route;

// Rutas de vistas estáticas
Route::get('/', function () { 
    return view('welcome'); 
})->name('welcome');

Route::get('/sobreNosotros', function () { 
    return view('sobreNosotros'); 
})->name('sobreNosotros');

Route::get('/crearFormulario', function () { 
    return view('crearFormulario'); 
})->name('crearFormulario');

// Rutas relacionadas con formularios
Route::get('/buscarFormularios', [FormularioController::class, 'buscarFormularios'])->name('buscarFormularios');
Route::get('/mostrarFormularios', [FormularioController::class, 'mostrarFormularios'])->name('mostrarFormularios');
Route::get('/formularios/{id}/editar', [FormularioController::class, 'editarFormulario'])->name('editarFormulario');
Route::get('/responderFormulario/{id}', [FormularioController::class, 'responderFormulario'])->name('responderFormulario');
Route::get('/verRespuestas/{id}', [FormularioController::class, 'verRespuestas'])->name('verRespuestas');

// Rutas para guardar datos
Route::post('/guardarFormulario', [FormularioController::class, 'guardarFormulario'])->name('guardarFormulario');
Route::post('/guardarRespuestas/{id}', [FormularioController::class, 'guardarRespuestas'])->name('guardarRespuestas');

// Rutas para actualizar y eliminar formularios
Route::put('/formularios/{id}', [FormularioController::class, 'update'])->name('empezar');
Route::delete('/formularios/{id}', [FormularioController::class, 'destroy'])->name('deleteFormulario');