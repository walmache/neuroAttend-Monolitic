@extends('adminlte::page')

@section('title', 'Registro de Asistencia')

@section('content')
<div class="card card-secondary">
    <div class="card-header">
        <h6 class="card-title">Registrar Asistencia</h6>
    </div>
    <div class="card-body">
        <form id="attendanceForm" action="{{ route('record.attendance.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-3">
                    <label for="meeting_id">Reunión:</label>
                </div>
                <div class="col-md-9">
                    <select id="meeting_id" name="meeting_id" class="form-control form-control-sm select2">
                        <option value="">Seleccione una reunión</option>
                        @foreach($meetings as $meeting)
                            <option value="{{ $meeting->id }}">{{ $meeting->description }}</option>
                        @endforeach
                    </select>
                    @error('meeting_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-3">
                    <label for="user_id">Usuario:</label>
                </div>
                <div class="col-md-9">
                    <select id="user_id" name="user_id" class="form-control form-control-sm select2">
                        <option value="">Seleccione un usuario</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-3">
                    <label>Firma:</label>
                </div>
                <div class="col-md-9 text-center">
                    <canvas id="signatureCanvas" class="border" width="500" height="200"></canvas>
                    <input type="hidden" name="signature" id="signatureInput">
                    <div class="mt-2">
                        <button type="button" id="clearSignature" class="btn btn-danger btn-sm">Borrar</button>
                    </div>
                </div>
            </div>

            <div class="mt-3 text-center">
                <button type="submit" class="btn btn-success btn-sm">Registrar Asistencia</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')

<script>
document.addEventListener('DOMContentLoaded', function () {
    $('.select2').select2({
            theme: 'classic',
            width: '100%',
            placeholder: 'Seleccione una opción'
        });

    var canvas = document.getElementById('signatureCanvas');
    var signaturePad = new SignaturePad(canvas);

    document.getElementById('clearSignature').addEventListener('click', function () {
        signaturePad.clear();
    });

    document.getElementById('attendanceForm').addEventListener('submit', function (e) {
        if (signaturePad.isEmpty()) {
            
            
            toastr.error("Por favor, firme antes de registrar la asistencia.");
            e.preventDefault();
            return;
        }
        document.getElementById('signatureInput').value = signaturePad.toDataURL();
    });
});
</script>
@endsection
