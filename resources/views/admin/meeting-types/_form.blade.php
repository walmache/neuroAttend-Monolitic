<!-- resources/views/admin/meeting_types/_form.blade.php -->
@php
    $formTitle = isset($meetingType) ? 'Editar Tipo de Reunión' : 'Nuevo Tipo de Reunión';
    $formAction = isset($meetingType) ? route('admin.meeting-types.update', $meetingType->id) : route('admin.meeting-types.store');
@endphp

<div class="card card-secondary">
    <div class="card-header">
        <h6 class="card-title">{{ $formTitle }}</h6>
    </div>
    <!-- Si es edición, usamos el método PUT o PATCH -->
    <form id="meetingType" method="POST" action="{{ $formAction }}" novalidate>
        @csrf
        @if(isset($meetingType))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 d-flex align-items-center">
                    <label for="name" class="col-form-label">Nombre:</label>
                </div>
                <div class="col-md">
                    <input type="text"
                           class="form-control form-control-sm {{ $errors->has('name') ? 'is-invalid' : '' }}"
                           id="name" name="name" placeholder="Nombre"
                           minlength="3" maxlength="100"
                           value="{{ old('name', $meetingType->name ?? '') }}" required>
                    <div class="invalid-feedback">
                        {{ $errors->first('name') ?: 'El nombre es requerido (3-100 caracteres)' }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 d-flex align-items-start">
                    <label for="description" class="col-form-label">Descripción:</label>
                </div>
                <div class="col-md">
                    <textarea class="form-control form-control-sm {{ $errors->has('description') ? 'is-invalid' : '' }}"
                              id="description" name="description" rows="2" placeholder="Descripción opcional" maxlength="500">{{trim(old('description', $meetingType->description ?? ''))}}</textarea>
                    <div class="invalid-feedback">
                        {{ $errors->first('description') ?: 'Máximo 500 caracteres permitidos' }}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer p-2">
            <button type="submit" class="btn btn-info btn-xs" id="submitBtn" disabled>Guardar</button>
            <button type="button" class="btn btn-default btn-xs float-right" onclick="resetForm()">Cancelar</button>
        </div>
    </form>
</div>
