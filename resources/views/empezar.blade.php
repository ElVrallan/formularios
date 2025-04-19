@extends('layouts.navbar')
<link rel="stylesheet" href="{{ asset('css/empezar.css') }}">

@section('content')
<div class="contenedor-empezar">
    <div class="cuadro-blanco">

        <div class="grid-formularios">
            <!-- Ítem NUEVO -->
            <a href="crearFormulario">
                <div class="item-nuevo">
                    <div class="cuadro-nuevo">
                        <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="white" class="bi bi-file-earmark-plus-fill" viewBox="0 0 16 16">
                            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M8.5 7v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 1 0" />
                        </svg>
                    </div>
                    <div class="etiqueta">Nuevo</div>
                </div>
            </a>


            <!-- Resto de los formularios -->
            @foreach ($formularios as $formulario)
            <div class="item-formulario">
                <img src="{{ asset('images/formulario default.png') }}" alt="Formulario" class="imagen-formulario">
                <div class="titulo-formulario">{{ $formulario->titulo }}</div>
            </div>
            @endforeach

        </div>

    </div>
</div>
@endsection