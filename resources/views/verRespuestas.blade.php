@extends('layouts.navbar')

@section('content')
<div class="layout-wrapper">
    <h1>Respuestas para: {{ $formulario->titulo }}</h1>
    <div class="responses-container">
        @forelse ($respuestas as $respuesta)
            <div class="response-block">
                <h3>Pregunta: {{ $respuesta->pregunta->pregunta }}</h3>
                <p><strong>Respuesta:</strong> {{ $respuesta->respuesta }}</p>
            </div>
        @empty
            <p>No hay respuestas para este formulario.</p>
        @endforelse
    </div>
</div>
@endsection
