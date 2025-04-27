<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formular.io</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/navBar.css') }}" rel="stylesheet">
</head>
<body>

<!-- Background SVG -->
<div class="background-svg">
    <img src="{{ asset('Images/fondo.svg') }}" alt="Background SVG" />
</div>

<header>
    <!-- Left Section: Logo -->
    <div class="left">
        <a href="/">Formular.io</a>
    </div>

    <!-- Botón menú hamburguesa (solo visible en móvil) -->
    @unless(Request::is('crearFormulario') || Request::is('responderFormulario*') || Request::is('formularios*'))
        <button class="menu-toggle" aria-label="Abrir menú">
            <svg xmlns="http://www.w3.org/2000/svg" fill="white" width="35" height="35" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
            </svg>
        </button>
    @endunless

    <!-- Center Section: "Sobre Nosotros" Link (solo en desktop) -->
    @unless(Request::is('crearFormulario') || Request::is('responderFormulario*') || Request::is('formularios*'))
        <div class="center">
            <a href="sobreNosotros">Sobre<br>nosotros</a>
        </div>
    @endunless

    <!-- Right Section: Search Bar (solo en desktop) -->
    @unless(Request::is('/') || Request::is('crearFormulario') || Request::is('responderFormulario*') || Request::is('formularios*'))
        <div class="right">
            <form class="search-bar" action="buscarFormularios" method="GET">
                <input type="text" name="q" placeholder="Buscar Formular.io a responder" aria-label="Buscar Formular.io a responder">
                <button type="submit" aria-label="Enviar búsqueda">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 16 16">
                        <path d="M6.5 4.482c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.69 0-5.018"/>
                        <path d="M13 6.5a6.47 6.47 0 0 1-1.258 3.844q.06.044.115.098l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1-.1-.115h.002A6.5 6.5 0 1 1 13 6.5M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11"/>
                    </svg>
                </button>
            </form>
        </div>
    @endunless
</header>

<!-- Menú móvil oculto -->
<div class="mobile-menu">
    @unless(Request::is('crearFormulario') || Request::is('responderFormulario*') || Request::is('formularios*'))
        <a href="sobreNosotros">Sobre Nosotros</a>
    @endunless

    @unless(Request::is('/') || Request::is('crearFormulario') || Request::is('responderFormulario*') || Request::is('formularios*'))
        <form class="search-bar" action="buscarFormularios" method="GET">
            <input type="text" name="q" placeholder="Buscar Formular.io a responder" aria-label="Buscar Formular.io a responder">
            <button type="submit" aria-label="Enviar búsqueda">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16">
                    <path d="M6.5 4.482c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.69 0-5.018"/>
                    <path d="M13 6.5a6.47 6.47 0 0 1-1.258 3.844q.06.044.115.098l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1-.1-.115h.002A6.5 6.5 0 1 1 13 6.5M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11"/>
                </svg>
            </button>
        </form>
    @endunless
</div>

<!-- Main Content -->
<main>
    @yield('content')
</main>

<script>
    const toggleButton = document.querySelector('.menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');

    toggleButton.addEventListener('click', () => {
        mobileMenu.style.display = (mobileMenu.style.display === 'flex') ? 'none' : 'flex';
    });
</script>

</body>
</html>
