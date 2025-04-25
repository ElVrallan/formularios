@extends('layouts.navbar')
<link rel="stylesheet" href="{{ asset('css/welcome.css') }}">

@section('content')

<div class="contenedor-bienvenida">
  <div class="bloque-izquierda">
    <img src="{{ asset('images/niño.svg') }}" alt="Niño" class="imagen-niño">

    <form class="search-bar-welcome" action="{{ route('buscarFormularios') }}" method="GET">
      <input type="text" name="q" placeholder="Buscar Formular.io a responder">
      <button type="submit">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 16 16">
          <path d="M6.5 4.482c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.69 0-5.018" />
          <path d="M13 6.5a6.47 6.47 0 0 1-1.258 3.844q.06.044.115.098l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1-.1-.115h.002A6.5 6.5 0 1 1 13 6.5M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11" />
        </svg>
      </button>
    </form>
  </div>

  <div class="rectangulo-derecha">
    <h2 class="titulo-formulario">
      <div class="linea-sup">¡Crea un increíble</div>
      <div class="linea-inf">Formular.io!</div>
    </h2>

    <div class="contenido">
      <!-- Ítem 1 -->
      <div class="item-formulario">
        <div class="texto">1. Facilitate la vida ;)</div>
        <div class="grupo-icono-texto">
          <img src="{{ asset('images/paloma check.svg') }}" alt="paloma-check" class="paloma-check">
          <div class="texto-pequeña">Claro que sí</div>
        </div>
      </div>

      <!-- Ítem 2 -->
      <div class="item-formulario">
        <div class="texto">2. Respuestas al toque</div>
        <div class="grupo-icono-texto">
          <img src="{{ asset('images/paloma check.svg') }}" alt="paloma-check" class="paloma-check">
          <div class="texto-pequeña">Todo en su lugar</div>
        </div>
      </div>

      <!-- Ítem 3 -->
      <div class="item-formulario">
        <div class="texto">3. Comparte fácil</div>
        <div class="grupo-icono-texto">
          <img src="{{ asset('images/paloma check.svg') }}" alt="paloma-check" class="paloma-check">
          <div class="texto-pequeña">¡Y a responder!</div>
        </div>
      </div>
    </div>

  <a href="mostrarFormularios" class="button">
    ¡A por ello!
    <img src="{{ asset('images/cohete.svg') }}" alt="cohete" class="cohete">
  </a>

  </div>
</div>

@endsection