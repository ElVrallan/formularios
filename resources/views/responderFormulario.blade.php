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
                                    <textarea name="respuestas[{{ $pregunta->id }}]" class="question-input auto-resize" rows="1" required></textarea>                                @elseif ($pregunta->tipo === 'Número')
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
                <button type="submit" class="envRespBtn">Enviar respuestas
                </button>
            </form>
        </div>

            <!-- Rectángulo derecho (barra lateral fija) -->
    <div class="sidebar-fixed">
        <div class="sidebar-buttons">
            <button class="circle-btn blue-btn">
                <div class="tooltip">Compartir <br> formulario</div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 16 16">
                    <path d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5" />
                </svg>
            </button>

        </div>

        <div class="sidebar-bottom-btn">
            <button class="circle-btn red-btn" id="deleteFormBtn">
                <div class="tooltip">Eliminar <br> formulario</div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Overlay oscuro y modal de confirmación -->
    <div id="deleteOverlay" class="overlay hidden">
        <div class="confirmation-box">
            <p class="confirmation-text">
                ¿Realmente deseas eliminar este formulario? <br>
                Se perderán todas las respuestas correspondientes
            </p>
            <div class="confirmation-buttons">
                <button id="cancelDelete" class="btn-cancel">NO :)</button>
                <a href="{{ url('/') }}" class="btn-confirm">SI D:</a>
            </div>
        </div>
    </div>
    </div>
</div>

<script>
    document.addEventListener('input', function (event) {
        if (event.target.classList.contains('auto-resize')) {
            event.target.style.height = 'auto'; // Resetea la altura
            event.target.style.height = event.target.scrollHeight + 'px'; // Ajusta la altura al contenido
        }
    });

    // Mostrar el overlay al hacer clic en el botón de eliminar
    document.getElementById('deleteFormBtn').addEventListener('click', function () {
        document.getElementById('deleteOverlay').classList.remove('hidden');
    });

    // Ocultar el overlay al hacer clic en el botón de cancelar
    document.getElementById('cancelDelete').addEventListener('click', function () {
        document.getElementById('deleteOverlay').classList.add('hidden');
    });
</script>
@endsection