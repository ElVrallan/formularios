<?php

namespace App\Http\Controllers;

use App\Models\formularioModel;
use App\Models\preguntasModel;
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

public function store(Request $request)
{
    $formulario = formularioModel::create([
        'titulo' => $request->input('titulo'),
    ]);

    $preguntasJson = $request->input('preguntasJson');
    $preguntas = json_decode($preguntasJson, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        dd('Error al decodificar JSON', json_last_error_msg(), $preguntasJson);
    }
    
    if (!is_array($preguntas)) {
        dd('El JSON no es un array', $preguntasJson);
    }
    
    if (is_array($preguntas)) {
        foreach ($preguntas as $p) {
            preguntasModel::create([
                'formulario_id' => $formulario->id,
                'pregunta' => $p['pregunta'],
                'tipo' => $p['tipo'],
                'opciones' => isset($p['opciones']) ? json_encode($p['opciones']) : null,
            ]);
        } 
        
        return redirect()->back()->with('success', 'Formulario guardado correctamente.');
    } else {
        // Puedes agregar esto para depurar si algo falla
        dd('El JSON no es válido o está vacío', $request->input('preguntasJson'));
    }
    
}

}
