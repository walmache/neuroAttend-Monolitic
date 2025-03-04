@extends('adminlte::page')

@section('title', 'Registro de Firma')

@section('content')
<div class="card card-secondary">
    <div class="card-header">
        <h6 class="card-title">Captura de Firma</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 text-center">
                <canvas id="signatureCanvas" class="border" width="500" height="200"></canvas>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12 text-center">
                <button id="clearSignature" class="btn btn-danger btn-sm">Borrar</button>
                <button id="saveSignature" class="btn btn-success btn-sm">Guardar Firma</button>
            </div>
        </div>
    </div>
</div>

<form id="signatureForm" method="POST" action="{{ route('record.attendance.store') }}">
    @csrf
    <input type="hidden" name="signature" id="signatureInput">
    <input type="hidden" name="meeting_id" value="{{ $meetingId }}">
    <input type="hidden" name="user_id" value="{{ $userId }}">
</form>

@endsection

@section('js')
    @push('js')
        @plugin('SignaturePad') {{-- Esto carga el plugin desde `adminlte.php` --}}
    @endpush

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var canvas = document.getElementById('signatureCanvas');
        var signaturePad = new SignaturePad(canvas);

        document.getElementById('clearSignature').addEventListener('click', function () {
            signaturePad.clear();
        });

        document.getElementById('saveSignature').addEventListener('click', function () {
            if (signaturePad.isEmpty()) {
                alert("Por favor, firme antes de guardar.");
                return;
            }
            document.getElementById('signatureInput').value = signaturePad.toDataURL();
            document.getElementById('signatureForm').submit();
        });
    });
    </script>
@endsection
