@extends('layouts.app')

@section('title', 'Dashboard')

@section('content_header')
<h1>Neuro Attend</h1>
@stop

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Sistema de Asistencias: Simple, Intuitivo y Tecnológico</h2>

    <p>
        El sistema de asistencias está diseñado pensando en la <strong>eficiencia</strong> y <strong>simplicidad</strong> del usuario final. Con una interfaz intuitiva y amigable, permite realizar el registro de entrada y salida en cuestión de segundos, eliminando procesos engorrosos y manuales. <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Facilidad de uso</span> es nuestra prioridad, y por eso los usuarios pueden marcar su asistencia desde diferentes dispositivos, ya sea a través de smartphones, tablets o computadoras.
    </p>
    <div class="alert alert-info mt-3" role="alert">
        <i class="fas fa-mobile-alt me-2"></i> ¡Flexibilidad total! Accede desde cualquier dispositivo.
    </div>

    <p>
        Incorpora <strong>tecnología avanzada</strong> que asegura precisión y confiabilidad en cada registro. Utilizando algoritmos de <span class="badge bg-primary"><i class="fas fa-map-marker-alt me-1"></i>geolocalización</span> y <span class="badge bg-warning text-dark"><i class="fas fa-user-circle me-1"></i>reconocimiento facial</span>, el sistema ofrece una capa adicional de seguridad y exactitud en la toma de asistencia. Estas innovaciones no solo reducen errores humanos, sino que también permiten automatizar procesos administrativos relacionados con la gestión del tiempo y la productividad.
    </p>
    <div class="alert alert-success mt-3" role="alert">
        <i class="fas fa-shield-alt me-2"></i> Seguridad garantizada con tecnología de vanguardia.
    </div>

    <p>
        La plataforma se destaca por su capacidad de integración con otros sistemas empresariales existentes, como <span class="badge bg-secondary"><i class="fas fa-file-invoice-dollar me-1"></i>nómina</span> y <span class="badge bg-secondary"><i class="fas fa-users me-1"></i>recursos humanos</span>. Esta interoperabilidad facilita la generación de reportes automáticos y análisis en tiempo real, proporcionando a los gerentes información valiosa para la toma de decisiones estratégicas. Además, cumple con los más altos estándares de seguridad informática, protegiendo los datos sensibles de la organización.
    </p>
    <div class="alert alert-warning mt-3" role="alert">
        <i class="fas fa-chart-line me-2"></i> Reportes en tiempo real para decisiones estratégicas.
    </div>

    <p>
        Finalmente, nuestro sistema de asistencias es <span class="badge bg-info text-dark"><i class="fas fa-expand-arrows-alt me-1"></i>escalable</span> y adaptable a las necesidades específicas de cada empresa, desde pequeñas organizaciones hasta grandes corporaciones. Ofrecemos actualizaciones constantes que incorporan las últimas tendencias tecnológicas, asegurando que siempre estarás a la vanguardia. La facilidad de implementación y el soporte técnico especializado garantizan una transición fluida hacia la digitalización de tus procesos de asistencia, maximizando la eficiencia operativa.
    </p>
    <div class="alert alert-primary mt-3" role="alert">
        <i class="fas fa-headset me-2"></i> Soporte técnico especializado para una implementación sin complicaciones.
    </div>
</div>
@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop