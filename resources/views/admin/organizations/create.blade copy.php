@extends('layouts.app')

@section('title', 'Nueva Organización')

@section('content_body')
<div class="row col d-flex justify-content-center pt-2">
    <div class="col-8">
        <div class="card card-info">
            <div class="card-header">
                <h6 class="card-title">Nueva Organización</h6>
            </div>
            <form id="organization" method="POST" action="{{ route('organizations.store') }}" novalidate>
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 d-flex align-items-center">
                            <label for="name" class="col-form-label">Nombre:</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Nombre" minlength="3" maxlength="100" required>
                            <div class="invalid-feedback">El nombre es requerido (3-100 caracteres)</div>
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <label for="address" class="col-form-label">Dirección:</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" id="address" name="address" placeholder="Dirección" minlength="5" maxlength="200" required>
                            <div class="invalid-feedback">La dirección debe tener entre 5 y 200 caracteres</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 d-flex align-items-center">
                            <label for="representative" class="col-form-label">Representante:</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" id="representative" name="representative" placeholder="Representante" minlength="3" maxlength="100" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ\s]+" required>
                            <div class="invalid-feedback">Nombre del representante requerido (3-100 caracteres)</div>
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <label for="phone" class="col-form-label">Teléfono:</label>
                        </div>
                        <div class="col-md-4">
                            <input type="tel" class="form-control form-control-sm" id="phone" name="phone" placeholder="Teléfono" pattern="[0-9+\- ]{6,20}" required>
                            <div class="invalid-feedback">Teléfono válido (6-20 dígitos, puede incluir + y -)</div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-2 d-flex align-items-center">
                            <label for="email" class="col-form-label">Email:</label>
                        </div>
                        <div class="col-md-4">
                            <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Email" maxlength="100" required>
                            <div class="invalid-feedback">Ingrese un correo electrónico válido</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 d-flex align-items-start">
                            <label for="notes" class="col-form-label">Observaciones:</label>
                        </div>
                        <div class="col-md-10">
                            <textarea class="form-control form-control-sm" id="notes" name="notes" rows="3" placeholder="Observaciones" maxlength="500"></textarea>
                            <div class="invalid-feedback">Máximo 500 caracteres permitidos</div>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-2">
                    <button type="submit" class="btn btn-info btn-xs" id="submitBtn" disabled>Guardar</button>
                    <button type="button" class="btn btn-default btn-xs float-right" onclick="resetForm()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('organization');
    const submitBtn = document.getElementById('submitBtn');

    window.resetForm = function() {
        form.reset();
        form.classList.remove('was-validated');
        form.querySelectorAll('.form-control').forEach(element => {
            element.classList.remove('is-valid', 'is-invalid');
        });
        submitBtn.disabled = true;
        form.querySelectorAll('.invalid-feedback').forEach(element => {
            element.style.display = 'none';
        });
    }

    form.querySelectorAll('input, textarea').forEach(element => {
        element.addEventListener('input', checkFormValidity);
        element.addEventListener('blur', checkFormValidity);
    });

    function checkFormValidity() {
        let isValid = true;
        form.querySelectorAll('input, textarea').forEach(element => {
            if (!element.checkValidity()) {
                isValid = false;
                element.classList.add('is-invalid');
                element.classList.remove('is-valid');
            } else {
                element.classList.add('is-valid');
                element.classList.remove('is-invalid');
            }
        });
        submitBtn.disabled = !isValid;
    }

    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});
</script>
@endpush
