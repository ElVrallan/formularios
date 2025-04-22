@extends('layouts.navbar')

@section('content')

<h1>Editar Formulario: {{ $formulario->titulo }}</h1>

@foreach ($preguntas as $pregunta)
    <div class="pregunta">
        <p><strong>Pregunta:</strong> {{ $pregunta->pregunta }}</p>
        <p><strong>Tipo:</strong> {{ $pregunta->tipo }}</p>
        @if($pregunta->opciones)
            <p><strong>Opciones:</strong> {{ implode(', ', json_decode($pregunta->opciones)) }}</p>
        @endif
    </div>
@endforeach

@endsection