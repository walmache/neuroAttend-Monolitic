@extends('layouts.app')

@section('title', 'Asistencias')

@section('content_body')

@include('partials.signature-modal') <!-- Incluir el modal aquí -->

<div class="card card-secondary">
    <div class="card-header d-flex justify-content-between align-items-center p-1">
        <h6 class="card-title flex-grow-1">Participantes de la reunión: <strong>{{ $meeting->description }}</strong></h6>
    </div>
    <div class="card-body pt-1 pb-1">
        <div class="table-responsive">
            <table id="attendanceTable" class="table table-hover table-sm beautify compressed bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Organización</th>
                        <th>Identificación</th>
                        <th>Login</th>
                        <th>Foto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $record)
                    <tr>
                        <td>{{ $record['name'] }}</td>
                        <td>{{ $record['email'] }}</td>
                        <td>{{ $record['organization'] }}</td>
                        <td>{{ $record['identification'] }}</td>
                        <td>{{ $record['login'] }}</td>
                        <td><img src="{{ $record['photo'] ? asset('storage/'.$record['photo']) : asset('img/default-avatar.png') }}"
                                class="img-thumbnail border border-primary" width="50"></td>
                        <td class="text-center">{!! $record['is_present'] !!}</td>
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
        $('#attendanceTable').DataTable();
    });

    // document.addEventListener("DOMContentLoad   ed", function() {
    //     document.querySelectorAll(".mark-attendance").forEach(function(checkbox) {
    //         checkbox.addEventListener("change", function() {
    //             if (this.checked) {
    //                 let userId = this.dataset.userId;
    //                 let meetingId = this.dataset.meetingId;
    //                 fetch("{{ route('admin.meetings.attendances.store', [':meeting_id', ':user_id']) }}"
    //                         .replace(':meeting_id', meetingId)
    //                         .replace(':user_id', userId), {
    //                             method: "POST",
    //                             headers: {
    //                                 "Content-Type": "application/json",
    //                                 "Accept": "application/json",
    //                                 "X-CSRF-TOKEN": "{{ csrf_token() }}"
    //                             },
    //                             body: JSON.stringify({
    //                                 user_id: userId,
    //                                 //_token: "{{ csrf_token() }}"
    //                             })
    //                         })
    //                     .then(response => {
    //                         if (!response.ok) {
    //                             return response.text().then(text => {
    //                                 throw new Error(text)
    //                             }); // Captura errores en HTML
    //                         }
    //                         return response.json();
    //                     })
    //                     .then(data => {
    //                         if (data.success) {
    //                             this.disabled = true;
    //                         } else {
    //                             alert("Error: " + data.message);
    //                             this.checked = false;
    //                         }
    //                     })
    //                     .catch(error => {
    //                         console.error("Error en la respuesta del servidor:", error);
    //                         alert("Error en el servidor. Revisa la consola para más detalles.");
    //                         this.checked = false;
    //                     });
    //             }
    //         });
    //     });
    // });
</script>
@stop


@push('js')
@include('partials.signature-script')
@endpush