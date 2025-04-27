@extends('layouts.navbar')
<link href="{{ asset('css/sobreNosotros.css') }}" rel="stylesheet">
@section('content')
    <div class="sobre-nosotros-container">
        <h1>Bienvenido a Formular.io</h1>
        <p>
            La solución definitiva para crear formularios dinámicos de manera rápida, sencilla y eficiente.
        </p>
        
        <div>
            <h2>¿Quiénes somos?</h2>
            <p>
                En <strong>Formular.io</strong>, nos especializamos en ofrecer una plataforma innovadora que permite a nuestros usuarios 
                diseñar formularios personalizados sin necesidad de conocimientos técnicos. Nuestra misión es simplificar procesos 
                complejos y ayudar a empresas y particulares a recopilar información de manera profesional.
            </p>
        </div>

        <div>
            <h2>¿Por qué elegir Formular.io?</h2>
            <ul>
                <li><strong>Fácil de usar:</strong> Una interfaz intuitiva que cualquiera puede dominar en minutos.</li>
                <li><strong>Altamente personalizable:</strong> Diseña formularios que se adapten a tus necesidades específicas.</li>
                {{-- <li><strong>Integraciones:</strong> Conecta tus formularios con herramientas populares como Google Sheets, Slack y más.</li> --}}
                <li><strong>Seguridad:</strong> Tus datos están protegidos con los más altos estándares de seguridad.</li>
                <li><strong>Soporte excepcional:</strong> Nuestro equipo está disponible para ayudarte en cada paso del camino.</li>
            </ul>
        </div>

        <div>
            <h2>Nuestros valores</h2>
            <p>
                En <strong>Formular.io</strong>, creemos en la innovación, la simplicidad y la satisfacción del cliente. 
                Nos esforzamos por ofrecer una experiencia única que transforme la manera en que las personas interactúan con los formularios.
            </p>
        </div>

        <div class="cta">
            <h3>¡Empieza hoy mismo!</h3>
            <p>
                Únete a miles de usuarios que ya están disfrutando de los beneficios de <strong>Formular.io</strong>. 
                ¡Crea formularios dinámicos y lleva tu productividad al siguiente nivel!
            </p>
            {{-- <a href="/register" class="btn-register">Regístrate Ahora</a> --}}
        </div>
    </div>
@endsection
