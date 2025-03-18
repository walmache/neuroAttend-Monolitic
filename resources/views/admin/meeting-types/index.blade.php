@extends('layouts.app')

@section('title', 'Tipos de Reunión')

@section('content_body')

<div class="card card-secondary">
    <div class="card-header d-flex justify-content-between align-items-center p-1">
        <h6 class="card-title flex-grow-1">Tipos de Reunión</h6>
        <a href="{{ route('admin.meeting-types.create') }}" class="btn btn-primary btn-sm "><i class="fas fa-plus-square"></i> Añadir </a>
    </div>
    <div class="card-body pt-1 pb-1">
        <div class="table-responsive ">
            <table id="meetingTypesTable" class="datatable table table-hover table-sm beautify compressed bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($meetingTypes as $record)
                    <tr>
                        <td>{{ $record['name'] }}</td>
                        <td>{{ $record['description'] }}</td>
                        <td class="text-center">{!! $record['actions'] !!}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
