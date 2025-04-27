@extends('layouts.navbar')

<link rel="stylesheet" href="{{ asset('css/crearFormulario.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@800&display=swap" rel="stylesheet">

@section('content')

<div class="layout-wrapper">
    <!-- Rectángulo izquierdo (formulario) -->
    <div class="form-container">
        <div class="form-banner-wrapper">
            <img src="{{ asset('Images/formulario banner default.png') }}" alt="Banner" class="form-image">
            <div class="editable-text" contenteditable="true" spellcheck="false">{{ $formulario->titulo }}</div>
        </div>

        <div class="form-body">
            <form id="formularioEdit" action="{{ route('empezar', $formulario->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="titulo" id="tituloFormulario">
                <input type="hidden" id="preguntasJson" name="preguntasJson">

                <div id="formFieldsContainer">
                    @foreach ($preguntas as $index => $pregunta)
                    <div class="question-block" data-type="{{ $pregunta->tipo }}">
                        <div class="question-header">
                            <div class="editable-question" contenteditable="true" spellcheck="false">
                                {{ $pregunta->pregunta }}</div>
                            <span class="question-type">({{ ucfirst($pregunta->tipo) }})</span>
                            <button type="button" class="delete-question-btn">
                                <span class="delete-text">Eliminar pregunta</span> 🗑️
                            </button>
                        </div>

                        <div class="response-container">
                            @if ($pregunta->tipo === 'Opción Múltiple')
                            <div class="multiple-options">
                                @foreach (json_decode($pregunta->opciones) as $opcion)
                                <div class="option-item">
                                    <input type="radio" disabled>
                                    <div class="editable-option" contenteditable="true" spellcheck="false">{{ $opcion }}
                                    </div>
                                    <button type="button" class="delete-option-btn">🗑️</button>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="add-option-btn">+ Agregar opción</button>
                            @elseif ($pregunta->tipo === 'Fecha')
                            <input type="date" class="question-input" value="{{ $pregunta->respuesta ?? '' }}">
                            @else
                            <input type="{{ $pregunta->tipo }}" class="question-input"
                                value="{{ $pregunta->respuesta ?? '' }}">
                            @endif
                        </div>
                    </div>
                    <hr class="divider-line">
                    @endforeach
                </div>

                <div class="add-button-wrapper">
                    <button id="addFieldToggle" class="add-btn" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#1CADE4"
                            class="bi bi-patch-plus-fill" viewBox="0 0 16 16">
                            <path
                                d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zM8.5 6v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 1 0" />
                        </svg>
                        <span>Agregar</span>
                    </button>

                    <div id="fieldOptions" class="field-options hidden">
                        <button type="button" class="field-option" data-type="multiple">Opción múltiple</button>
                        <button type="button" class="field-option" data-type="text">Texto</button>
                        <button type="button" class="field-option" data-type="number">Número</button>
                        <button type="button" class="field-option" data-type="date">Fecha</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Rectángulo derecho (barra lateral fija) -->
    <div class="sidebar-fixed">
        <div class="sidebar-buttons">
            <!-- Botón Compartir -->
            <button class="circle-btn blue-btn" id="shareFormBtn">
                <div class="tooltip">Compartir <br> formulario</div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 16 16">
                    <path
                        d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5" />
                </svg>
            </button>

            <!-- Botón Guardar -->
            <button class="circle-btn blue-btn" type="submit" id="guardarFormularioBtn">
                <div class="tooltip">Guardar <br> formulario</div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 16 16">
                    <path
                        d="M0 1.5A1.5 1.5 0 0 1 1.5 0H3v5.5A1.5 1.5 0 0 0 4.5 7h7A1.5 1.5 0 0 0 13 5.5V0h.086a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5H14v-5.5A1.5 1.5 0 0 0 12.5 9h-9A1.5 1.5 0 0 0 2 10.5V16h-.5A1.5 1.5 0 0 1 0 14.5z" />
                    <path
                        d="M3 16h10v-5.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5zm9-16H4v5.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5zM9 1h2v4H9z" />
                </svg>
            </button>

            <!-- Botón Ver Respuestas -->
            <button class="circle-btn blue-btn">
                <div class="tooltip">Ver <br> respuestas</div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 16 16">
                    <path
                        d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z" />
                    <path
                        d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0M7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0" />
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
</div>

<div id="deleteOverlay" class="overlay hidden">
    <div class="confirmation-box">
        <p class="confirmation-text">
            ¿Realmente deseas eliminar este formulario? <br>
            Se perderán todas las respuestas correspondientes
        </p>
        <div class="confirmation-buttons">
            <button id="cancelDelete" class="btn-cancel">NO :)</button>
            <form action="{{ route('deleteFormulario', $formulario->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-confirm">SI D:</button>
            </form>
        </div>
    </div>
</div>

<div id="shareOverlay" class="overlay hidden">
    <div class="share-box">
        <p class="share-text">Código: <span id="formCode">{{ $formulario->id }}</span></p>
        <input type="text" id="shareUrl" class="share-input" value="{{ url('responderFormulario', ['id' => $formulario->id]) }}" readonly>
        <button id="copyCodeBtn" class="btn-copy">Copiar Código</button>
        <button id="copyUrlBtn" class="btn-copy">Copiar URL</button>
        <button id="closeShareOverlay" class="btn-cancel">Cerrar</button>
    </div>
</div>

<script src="{{ asset('js/form-builder.js') }}"></script>
@endsection