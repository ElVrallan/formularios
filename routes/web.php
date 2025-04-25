<?php
use App\Http\Controllers\FormularioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome');})->name('welcome');
Route::get('/sobreNosotros', function () { return view('sobreNosotros');})->name('sobreNosotros');
Route::get('/buscarFormularios', [formularioController::class, 'buscarFormularios'])->name('buscarFormularios');
Route::get('/mostrarFormularios', [formularioController::class, 'mostrarFormularios'])->name('mostrarFormularios');
Route::get('/crearFormulario', function () { return view('crearFormulario');})->name('crearFormulario');
Route::get('/formularios/{id}/editar', [formularioController::class, 'editarFormulario'])->name('editarFormulario');

Route::post('/guardarFormulario', [formularioController::class, 'guardarFormulario'])->name('guardarFormulario');
Route::put('/formularios/{id}', [FormularioController::class, 'update'])->name('empezar');
Route::delete('/formularios/{id}', [FormularioController::class, 'destroy'])->name('deleteFormulario');