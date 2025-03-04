<!-- resources/views/admin/meetings/_form.blade.php -->
@php
$formTitle = isset($meeting) ? 'Editar Reunión' : 'Nueva Reunión';
$formAction = isset($meeting) ? route('admin.meetings.update', $meeting->id) : route('admin.meetings.store');
@endphp

<div class="card card-secondary">
    <div class="card-header">
        <h6 class="card-title">{{ $formTitle }}</h6>
    </div>

    <form id="meetingForm" method="POST" action="{{ $formAction }}" novalidate>
        @csrf
        @if(isset($meeting))
        @method('PUT')
        @endif

        <div class="card-body">
            <div class="row">
                <!-- Organización -->
                <div class="col-md-2 d-flex align-items-center">
                    <label for="organization_id" class="col-form-label">Organización:</label>
                </div>
                <div class="col-md-4">
                    <select class="form-control form-control-sm select2 {{ $errors->has('organization_id') ? 'is-invalid' : '' }}"
                        id="organization_id" name="organization_id" required>
                        <option value="">Seleccione una organización</option>
                        @foreach($organizations as $organization)
                        <option value="{{ $organization->id }}"
                            {{ old('organization_id', $meeting->organization_id ?? '') == $organization->id ? 'selected' : '' }}>
                            {{ $organization->name }}
                        </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        {{ $errors->first('organization_id') ?: 'Seleccione una organización válida.' }}
                    </div>
                </div>

                <!-- Tipo de reunión -->
                <div class="col-md-2 d-flex align-items-center">
                    <label for="meeting_type_id" class="col-form-label">Tipo de Reunión:</label>
                </div>
                <div class="col-md-4">
                    <select class="form-control form-control-sm select2 {{ $errors->has('meeting_type_id') ? 'is-invalid' : '' }}"
                        id="meeting_type_id" name="meeting_type_id" required>
                        <option value="">Seleccione un tipo de reunión</option>
                        @foreach($meetingTypes as $meetingType)
                        <option value="{{ $meetingType->id }}"
                            {{ old('meeting_type_id', $meeting->meeting_type_id ?? '') == $meetingType->id ? 'selected' : '' }}>
                            {{ $meetingType->name }}
                        </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        {{ $errors->first('meeting_type_id') ?: 'Seleccione un tipo de reunión válido.' }}
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <!-- Fecha y Hora (Date and Time Range Picker) -->
                <div class="col-md-2 d-flex align-items-center">
                    <label for="datetime" class="col-form-label">Fecha y Hora:</label>
                </div>
                <div class="col-md-4">
                    <div class="input-group  input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                        </div>
                        <input type="text"
                            class="form-control form-control-sm datetimepicker {{ $errors->has('datetime') ? 'is-invalid' : '' }}"
                            id="datetime" name="datetime"
                            value="{{ old('datetime', isset($meeting) ? $meeting->date . ' ' . $meeting->time : '') }}" required>
                        <div class="invalid-feedback">
                            {{ $errors->first('datetime') ?: 'Ingrese una fecha y hora válidas.' }}
                        </div>
                    </div>
                </div>

                <!-- Ubicación -->
                <div class="col-md-2 d-flex align-items-center">
                    <label for="location" class="col-form-label">Ubicación:</label>
                </div>
                <div class="col-md-4">
                    <input type="text"
                        class="form-control form-control-sm {{ $errors->has('location') ? 'is-invalid' : '' }}"
                        id="location" name="location" placeholder="Ubicación"
                        maxlength="200"
                        value="{{ old('location', $meeting->location ?? '') }}" required>
                    <div class="invalid-feedback">
                        {{ $errors->first('location') ?: 'Máximo 200 caracteres permitidos.' }}
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <!-- Descripción -->
                <div class="col-md-2 d-flex align-items-start">
                    <label for="description" class="col-form-label">Descripción:</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control form-control-sm {{ $errors->has('description') ? 'is-invalid' : '' }}"
                        id="description" name="description" rows="2" placeholder="Descripción opcional" maxlength="500">{{ trim(old('description', $meeting->description ?? '')) }}</textarea>
                    <div class="invalid-feedback">
                        {{ $errors->first('description') ?: 'Máximo 500 caracteres permitidos.' }}
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