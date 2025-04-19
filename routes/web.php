<?php
use App\Http\Controllers\FormularioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome');})->name('welcome');
Route::get('/sobreNosotros', function () { return view('sobreNosotros');})->name('sobreNosotros');
Route::get('/buscarFormularios', [formularioController::class, 'buscarFormularios'])->name('buscarFormularios');
Route::get('/empezar', [formularioController::class, 'mostrarFormularios'])->name('empezar');
Route::get('/crearFormulario', function () { return view('crearFormulario');})->name('crearFormulario');
