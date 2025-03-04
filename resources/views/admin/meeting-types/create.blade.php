@extends('layouts.app')

@section('title', 'Nueva Organización')

@section('content_body')
<div class="row col d-flex justify-content-center pt-2">
    <div class="col-8">
        @include('admin.meeting-types._form')
    </div>
</div>
@endsection

@push('js')
    @include('admin.meeting-types._form-scripts')
@endpush