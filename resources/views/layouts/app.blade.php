@extends('adminlte::page')

@section('title', config('adminlte.title'))

@section('content_header')
@hasSection('content_header_title')
<h6>@yield('content_header_title')</h6>
@hasSection('content_header_subtitle')
<small>@yield('content_header_subtitle')</small>
@endif
@endif
@endsection

@section('content')
@yield('content_body')
@endsection

@section('footer')
<strong>© {{ date('Y') }} <a href="https://neurotic.com">NeuroTIC</a></strong>. Todos los derechos reservados.
<div class="float-right d-none d-sm-inline-block"><b>Powered by</b> NeuroTIC</div>
@endsection

@push('js')
<script>
    window.flashMessages = @json(session()->all());
    
    window.sessionData = {
            success: @json(session('success')),
            error: @json(session('error')),
            warning: @json(session('warning')),
            info: @json(session('info')),
            errors: @json($errors->all()),
            sessionLifetime: {{ config('session.lifetime') }},
        };
</script>
@endpush