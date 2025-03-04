@extends('layouts.app')

@section('title', 'Nueva Reunión')

@section('content_body')
<div class="row col d-flex justify-content-center pt-2">
    <div class="col-8">
        @include('admin.users._form')
    </div>
</div>
@endsection

@push('js')
    @include('admin.users._form-scripts')
@endpush
