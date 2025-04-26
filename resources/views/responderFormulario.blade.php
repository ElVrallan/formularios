@extends('layouts.navbar')

<link rel="stylesheet" href="{{ asset('css/crearFormulario.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@800&display=swap" rel="stylesheet">

@section('content')

<div class="layout-wrapper">
    <!-- Rectángulo izquierdo (formulario) -->
    <div class="form-container">
        <div class="form-banner-wrapper">
            <img src="{{ asset('Images/formulario banner default.png') }}" alt="Banner" class="form-image">
            <div class="editable-text" contenteditable="false" spellcheck="false">{{ $formulario->titulo }}</div>
        </div>

        <div class="form-body">
            <form id="formularioResponder" action="{{ route('guardarRespuestas', ['id' => $formulario->id]) }}" method="POST">
                @csrf
                <div id="formFieldsContainer">
                    @foreach ($preguntas as $pregunta)
                        <div class="question-block" data-type="{{ $pregunta->tipo }}">
                            <div class="question-header">
                                <div class="editable-question" contenteditable="false" spellcheck="false">{{ $pregunta->pregunta }}</div>
                                <span class="question-type">({{ ucfirst($pregunta->tipo) }})</span>
                            </div>
                            <div class="response-container">
                                @if ($pregunta->tipo === 'Texto')
                                    <!-- Input para preguntas de texto -->
                                    <input type="text" name="respuestas[{{ $pregunta->id }}]" class="question-input" required>
                                @elseif ($pregunta->tipo === 'Número')
                                    <!-- Input para preguntas de número -->
                                    <input type="number" name="respuestas[{{ $pregunta->id }}]" class="question-input" required>
                                @elseif ($pregunta->tipo === 'Fecha')
                                    <!-- Input para preguntas de fecha -->
                                    <input type="date" name="respuestas[{{ $pregunta->id }}]" class="question-input" required>
                                @elseif ($pregunta->tipo === 'Opción Múltiple')
                                    <!-- Opciones para preguntas de opción múltiple -->
                                    <div class="multiple-options">
                                        @if (!empty($pregunta->opciones))
                                            @foreach (json_decode($pregunta->opciones, true) as $opcion)
                                                <div class="option-item">
                                                    <input type="radio" name="respuestas[{{ $pregunta->id }}]" value="{{ $opcion }}" id="opcion-{{ $pregunta->id }}-{{ $loop->index }}" required>
                                                    <label for="opcion-{{ $pregunta->id }}-{{ $loop->index }}" class="editable-option">{{ $opcion }}</label>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="error-message">No hay opciones disponibles para esta pregunta.</p>
                                        @endif
                                    </div>
                                @elseif ($pregunta->tipo === 'checkbox')
                                    <!-- Opciones para preguntas de tipo checkbox -->
                                    <div class="multiple-options">
                                        @if (!empty($pregunta->opciones))
                                            @foreach (json_decode($pregunta->opciones, true) as $opcion)
                                                <div class="option-item">
                                                    <input type="checkbox" name="respuestas[{{ $pregunta->id }}][]" value="{{ $opcion }}" id="checkbox-{{ $pregunta->id }}-{{ $loop->index }}">
                                                    <label for="checkbox-{{ $pregunta->id }}-{{ $loop->index }}" class="editable-option">{{ $opcion }}</label>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="error-message">No hay opciones disponibles para esta pregunta.</p>
                                        @endif
                                    </div>
                                @else
                                    <p class="error-message">Tipo de pregunta no soportado.</p>
                                @endif
                            </div>
                            <hr class="divider-line">
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="circle-btn blue-btn">
                    <div class="tooltip">Enviar respuestas</div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 16 16">
                        <path d="M0 1.5A1.5 1.5 0 0 1 1.5 0H3v5.5A1.5 1.5 0 0 0 4.5 7h7A1.5 1.5 0 0 0 13 5.5V0h.086a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5H14v-5.5A1.5 1.5 0 0 0 12.5 9h-9A1.5 1.5 0 0 0 2 10.5V16h-.5A1.5 1.5 0 0 1 0 14.5z" />
                        <path d="M3 16h10v-5.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5zm9-16H4v5.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5zM9 1h2v4H9z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

@endsection