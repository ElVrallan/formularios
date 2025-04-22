<?php

namespace App\Http\Controllers;

use App\Models\FormularioModel;
use App\Models\PreguntasModel;
use Illuminate\Http\Request;

class FormularioController extends Controller
{
    /**
     * Buscar formularios por ID o título.
     */
    public function buscarFormularios(Request $request)
    {
        $q = $request->input('q');

        $formularios = is_numeric($q)
            ? FormularioModel::where('id', $q)->get()
            : FormularioModel::where('titulo', 'like', '%' . $q . '%')->get();

        return view('resultados', compact('formularios'));
    }

    /**
     * Mostrar todos los formularios ordenados por ID descendente.
     */
    public function mostrarFormularios()
    {
        $formularios = FormularioModel::orderBy('id', 'desc')->get();
        return view('empezar', compact('formularios'));
    }

    /**
     * Almacenar un nuevo formulario con sus preguntas asociadas.
     */
    public function guardarFormulario(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'preguntasJson' => 'required|string',
        ]);

        $formulario = FormularioModel::create([
            'titulo' => $request->input('titulo'),
        ]);

        $preguntas = json_decode($request->input('preguntasJson'), true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($preguntas)) {
            return redirect()->back()->withErrors([
                'preguntasJson' => 'El formato JSON de las preguntas no es válido.',
            ])->withInput();
        }

        foreach ($preguntas as $pregunta) {
            PreguntasModel::create([
                'formulario_id' => $formulario->id,
                'pregunta' => $pregunta['pregunta'],
                'tipo' => $pregunta['tipo'],
                'opciones' => isset($pregunta['opciones']) ? json_encode($pregunta['opciones']) : null,
            ]);
        }

        return redirect()->back()->with('success', 'Formulario guardado correctamente.');
    }
}
