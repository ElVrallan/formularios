@extends('layouts.navbar')
<link rel="stylesheet" href="{{ asset('css/crearFormulario.css') }}">
@section('content')
<div class="layout-wrapper">
    <div class="white-box" style="border-radius: 0; width: auto;">
        <h1>Respuestas para: {{ $formulario->titulo }}</h1>
        @if ($respuestas->isNotEmpty())
            @php
                // Agrupar respuestas por el ID de la respuesta (asumiendo que cada respuesta pertenece a una pregunta)
                $groupedRespuestas = $respuestas->groupBy('pregunta_id');
                $preguntas = $groupedRespuestas->keys()->map(function ($preguntaId) {
                    return \App\Models\PreguntasModel::find($preguntaId);
                });
            @endphp
            <table class="styled-table rounded-table">
                <thead>
                    <tr>
                        <th>#</th>
                        @foreach ($preguntas as $pregunta)
                            <th>{{ $pregunta->pregunta }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groupedRespuestas->first() as $index => $respuesta)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            @foreach ($preguntas as $pregunta)
                                <td>
                                    {{ $groupedRespuestas[$pregunta->id][$index]->respuesta ?? 'N/A' }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No hay respuestas para este formulario.</p>
        @endif
    </div>
</div>
@endsection
