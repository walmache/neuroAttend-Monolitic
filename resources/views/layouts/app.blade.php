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
    window.flashMessages.errors = @json($errors->toArray());
    window.sessionData = {
        sessionLifetime: @json(config('session.lifetime'))
    }; 
</script>
@endpush