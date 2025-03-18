@extends('layouts.app')

@section('title', 'Organizaciones')

@section('content_body')

<div class="card card-secondary">
    <div class="card-header d-flex justify-content-between align-items-center p-1">
        <h6 class="card-title flex-grow-1">Listado de Organizaciones</h6>
        <a href="{{ route('admin.organizations.create') }}" class="btn btn-primary btn-sm "><i class="fas fa-plus-square"></i> Añadir </a>
    </div>
    <div class="card-body pt-1 pb-1">
        <div class="table-responsive ">
            <table id="organizationsTable" class="datatable table table-hover table-sm beautify compressed bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Email</th>
                        <th>Representante</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($organizations as $organization)
                    <tr>
                        <td>{{ $organization['name'] }}</td>
                        <td>{{ $organization['address'] }}</td>
                        <td>{{ $organization['email'] }}</td>
                        <td>{{ $organization['representative'] }}</td>
                        <td class="text-center">{!! $organization['actions'] !!}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection