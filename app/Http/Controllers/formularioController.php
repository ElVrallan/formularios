<?php

namespace App\Http\Controllers;

use App\Models\formularioModel;
use Illuminate\Http\Request;

class formularioController extends Controller
{
    // Método para buscar formularios por ID o título
    public function buscarFormularios(Request $request)
    {
        $q = $request->input('q');  // Capturamos el término de búsqueda

        // Verificamos si es un número (buscar por ID) o texto (buscar por título)
        if (is_numeric($q)) {
            $resultados = formularioModel::where('id', $q)->get();
        } else {
            $resultados = formularioModel::where('titulo', 'like', '%' . $q . '%')->get();
        }

        // Retornamos la vista con los resultados
        return view('resultados', ['formularios' => $resultados]);
    }

    public function mostrarFormularios()
    {
        $formularios = FormularioModel::orderBy('id', 'desc')->get(); // Orden descendente
        return view('empezar', compact('formularios'));
    }
}
