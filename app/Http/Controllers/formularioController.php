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

        return view('buscarFormularios', compact('formularios'));
    }

    /**
     * Mostrar todos los formularios ordenados por ID descendente.
     */
    public function mostrarFormularios()
    {
        $formularios = FormularioModel::orderBy('id', 'desc')->get();
        return view('mostrarFormularios', compact('formularios'));
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

        return redirect()->route('mostrarFormularios')->with('success', 'Formulario guardado correctamente.');
    }

    
    /**
     * Editar un formulario existente con sus preguntas asociadas.
     */
    public function editarFormulario($id)
    {
        // Obtener el formulario por ID
        $formulario = FormularioModel::findOrFail($id);

        // Obtener las preguntas relacionadas
        $preguntas = PreguntasModel::where('formulario_id', $id)->get();

        // Pasar datos a la vista
        return view('editarFormulario', compact('formulario', 'preguntas'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos enviados
        $request->validate([
            'titulo' => 'required|string|max:255',
            'preguntasJson' => 'required|json',
        ]);

        // Buscar el formulario por ID
        $formulario = FormularioModel::findOrFail($id);

        // Actualizar el título del formulario
        $formulario->titulo = $request->input('titulo');
        $formulario->save();

        // Decodificar las preguntas del JSON
        $preguntas = json_decode($request->input('preguntasJson'), true);

        // Obtener los IDs de las preguntas enviadas
        $preguntaIds = array_filter(array_column($preguntas, 'id'));

        // Eliminar preguntas que ya no están en el JSON
        PreguntasModel::where('formulario_id', $formulario->id)
            ->whereNotIn('id', $preguntaIds)
            ->delete();

        // Actualizar las preguntas existentes y manejar nuevas
        foreach ($preguntas as $preguntaData) {
            if (isset($preguntaData['id'])) {
                // Actualizar pregunta existente
                $pregunta = PreguntasModel::findOrFail($preguntaData['id']);
                $pregunta->pregunta = $preguntaData['pregunta'];
                $pregunta->tipo = $preguntaData['tipo'];
                $pregunta->opciones = isset($preguntaData['opciones']) ? json_encode($preguntaData['opciones']) : null;
                $pregunta->save();
            } else {
                // Crear nueva pregunta
                PreguntasModel::create([
                    'formulario_id' => $formulario->id,
                    'pregunta' => $preguntaData['pregunta'],
                    'tipo' => $preguntaData['tipo'],
                    'opciones' => isset($preguntaData['opciones']) ? json_encode($preguntaData['opciones']) : null,
                ]);
            }
        }

        // Redirigir con un mensaje de éxito
        return redirect()->route('mostrarFormularios')->with('success', 'Formulario actualizado correctamente.');
    }

    /**
     * Eliminar un formulario junto con sus preguntas y respuestas relacionadas.
     */
    public function destroy($id)
    {
        $formulario = FormularioModel::find($id);

        if ($formulario) {
            // Verificar si el formulario tiene preguntas relacionadas
            if ($formulario->preguntas && $formulario->preguntas->isNotEmpty()) {
                foreach ($formulario->preguntas as $pregunta) {
                    $pregunta->respuestas()->delete(); // Eliminar respuestas relacionadas
                    $pregunta->delete(); // Eliminar la pregunta
                }
            }

            // Eliminar el formulario
            $formulario->delete();
        }

        return redirect()->route('mostrarFormularios')->with('success', 'Formulario eliminado correctamente.');
    }

    public function responderFormulario($id)
    {
        // Obtener el formulario por ID
        $formulario = FormularioModel::findOrFail($id);
    
        // Obtener las preguntas relacionadas manualmente
        $preguntas = PreguntasModel::where('formulario_id', $formulario->id)->get();
    
        // Pasar los datos del formulario y las preguntas a la vista
        return view('responderFormulario', compact('formulario', 'preguntas'));
    }

public function guardarRespuestas(Request $request, $id)
{
    $formulario = FormularioModel::findOrFail($id);

    foreach ($request->input('respuestas') as $preguntaId => $respuesta) {
        // Guardar cada respuesta en la base de datos
        \App\Models\RespuestasModel::create([
            'pregunta_id' => $preguntaId,
            'respuesta' => $respuesta,
        ]);
    }

    return redirect()->route('welcome')->with('success', 'Respuestas enviadas correctamente.');
}
}