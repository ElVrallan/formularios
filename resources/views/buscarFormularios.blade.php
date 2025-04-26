@extends('layouts.navbar') 
<link rel="stylesheet" href="{{ asset('css/empezar.css') }}">

@section('content')
<div class="contenedor-empezar">
    <div class="cuadro-blanco">

        <div class="grid-formularios">
            @forelse ($formularios as $formulario)
            <a href="{{ route('responderFormulario', $formulario->id) }}" class="item-formulario-link">
                    <img src="{{ asset('images/formulario default.png') }}" alt="Formulario" class="imagen-formulario">
                    <div class="titulo-formulario">{{ $formulario->titulo }}</div>
                </a>
            @empty
                <p>No se encontraron resultados para: <strong>{{ request('q') }}</strong></p>
            @endforelse
        </div>

    </div>
</div>
@endsection