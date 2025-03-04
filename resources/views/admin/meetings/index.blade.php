@extends('layouts.app')

@section('title', 'Reuniones')

@section('content_body')

<div class="card card-secondary">
    <div class="card-header d-flex justify-content-between align-items-center p-1">
        <h6 class="card-title flex-grow-1">Reuniones</h6>
        <a href="{{ route('admin.meetings.create') }}" class="btn btn-primary btn-sm "><i class="fas fa-plus-square"></i> Añadir </a>
    </div>
    <div class="card-body pt-1 pb-1">
        <div class="table-responsive ">
            <table id="meetingsTable" class="table table-hover table-sm beautify compressed bordered">
                <thead>
                    <tr>
                        <th>Organización</th>
                        <th>Tipo</th>
                        <th>Fecha</th>
                        <th>Lugar</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($meetings as $record)
                    <tr>
                        <td>{{ $record['organization'] }}</td>
                        <td>{{ $record['meeting_type'] }}</td>
                        <td>{{ $record['datetime'] }}</td>
                        <td>{{ $record['location'] }}</td>
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

@section('js')
<script>
    $(document).ready(function() {
        $('#meetingsTable').DataTable();
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('click', function(e) {
            let button = e.target.closest('.toggle-status-form button');
            if (!button) return; // Si no es un botón dentro del formulario, salir

            e.preventDefault();
            let form = button.closest('form');
            let isActive = button.getAttribute('data-status') === '1';

            Swal.fire({
                title: isActive ? '¿Inactivar registro?' : '¿Reactivar registro?',
                html: isActive ?
                    '<div class="text-danger mb-3"><i class="fa fa-exclamation-triangle fa-3x"></i></div><p>¡Esta acción no se puede deshacer!</p>' : '<div class="text-success mb-3"><i class="fa fa-check-circle fa-3x"></i></div><p>La organización será activada nuevamente.</p>',
                showCancelButton: true,
                confirmButtonColor: isActive ? '#d33' : '#28a745',
                cancelButtonColor: '#3085d6',
                confirmButtonText: isActive ? '<i class="fa fa-trash"></i> Inactivar' : '<i class="fa fa-check"></i> Reactivar',
                cancelButtonText: '<i class="fa fa-times"></i> Cancelar',
                allowOutsideClick: false
            }).then((result) => {
                if (result.value) {
                    form.submit();
                }
            });
        });
    });
</script>
@stop