@extends('adminlte::auth.login')

@push('js')
    <script>
        @if ($errors->has('email'))
            toastr.error("{{ $errors->first('email') }}");
        @endif
    </script>
@endpush

