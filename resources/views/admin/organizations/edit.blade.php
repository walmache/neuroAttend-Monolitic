@extends('layouts.app')

@section('title', 'Editar Organización')

@section('content_body')
<div class="row col d-flex justify-content-center pt-2">
    <div class="col-8">
        @include('admin.organizations._form')
    </div>
</div>
@endsection

@push('js')
    @include('admin.organizations._form-scripts')
@endpush
