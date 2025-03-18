<!-- resources/views/admin/meetings/_form.blade.php -->
@php
$formTitle  = isset($meeting) ? 'Editar Reunión' : 'Nueva Reunión';
$formTitle .= (!empty($meetingType) && isset($meetingType->id) ? ' - ' . $meetingType->name : '');
$formAction = isset($meeting) ? route('admin.meetings.update', $meeting->id) : route('admin.meetings.store');
@endphp
<div class="card card-secondary">
    <div class="card-header">
        <h6 class="card-title">{{ $formTitle }}</h6>
    </div>
    <form id="meeting" method="POST" action="{{ $formAction }}" novalidate>
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
                    <label for="meeting_type_id" class="col-form-label">Tipo:</label>
                </div>
                <div class="col-md-4">
                    <select class="form-control form-control-sm select2 {{ $errors->has('meeting_type_id') ? 'is-invalid' : '' }}"
                        id="meeting_type_id" name="meeting_type_id" required>
                        @if (isset($meetingType) && $meetingType && $meetingType->id)
                            <option value="{{ $meetingType->id }}" selected>{{ $meetingType->name }}</option>
                        @else
                            <option value="">Seleccione un tipo de reunión</option>
                            @foreach($meetingTypes as $meetingType)
                            <option value="{{ $meetingType->id }}"
                                {{ old('meeting_type_id', $meeting->meeting_type_id ?? '') == $meetingType->id ? 'selected' : '' }}>
                                {{ $meetingType->name }}
                            </option>
                            @endforeach
                        @endif
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
                        <input type="text" 
                            class="form-control form-control-sm datetimepicker {{ $errors->has('datetime') ? 'is-invalid' : '' }}"
                            id="datetime" name="datetime" 
                            value="{{ old('datetime', isset($meeting) ? $meeting->datetime->format('Y-m-d H:i') : '') }}"
                            required>
                            <div class="input-group-append">
                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                        </div>
                        <div class="invalid-feedback">
                            {{ $errors->first('datetime') ?: 'Ingrese una fecha y hora válidas.' }}
                        </div>
                    </div>
                </div>

                <!-- Duración -->
                <div class="col-md-2 d-flex align-items-center">
                    <label for="duration" class="col-form-label">Tiempo (min):</label>
                </div>
                <div class="col-md-4">
                    <input type="number"
                        class="form-control form-control-sm {{ $errors->has('duration') ? 'is-invalid' : '' }}"
                        id="duration" name="duration" placeholder="Duración en minutos"
                        value="{{ old('duration', $meeting->duration ?? '60') }}" 
                        
                        required>
                    <div class="invalid-feedback">
                        {{ $errors->first('duration') ?: 'Ingrese una duración válida.' }}
                    </div>
                </div>
            </div>


            <div class="row mt-2">
                <!-- Virtual -->
                <div class="col-md-2 d-flex align-items-center">
                    <label for="is_virtual" class="col-form-label">Virtual:</label>
                </div>
                <!--<div class="col-md-2">
                    <input type="checkbox"
                        class="form-check-input {{ $errors->has('is_virtual') ? 'is-invalid' : '' }}"
                        id="is_virtual" name="is_virtual" {{ old('is_virtual', $meeting->is_virtual ?? false) ? 'checked' : '' }}>
                    <div class="invalid-feedback">
                        {{ $errors->first('is_virtual') ?: 'Seleccione si es una reunión virtual.' }}
                    </div>
                </div> -->

                <div class="col-md-1 d-flex align-items-center">
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="is_virtual" name="is_virtual" {{ old('is_virtual', $meeting->is_virtual ?? false) ? 'checked' : '' }}>
                        <label for="is_virtual"></label>
                    </div>
                    @if($errors->has('is_virtual'))
                        <div class="text-danger">
                            {{ $errors->first('is_virtual') ?: 'Seleccione si es una reunión virtual.' }}
                        </div>
                    @endif
                </div>



                <!-- Ubicación -->
                <div class="col-md-2 d-flex align-items-center">
                    <label for="location" class="col-form-label">Ubicación:</label>
                </div>
                <div class="col-md-7">
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
                <!-- Capacidad -->
                <div class="col-md-2 d-flex align-items-center">
                    <label for="capacity" class="col-form-label">Capacidad:</label>
                </div>
                <div class="col-md-4">
                    <input type="number"
                        class="form-control form-control-sm {{ $errors->has('capacity') ? 'is-invalid' : '' }}"
                        id="capacity" name="capacity" placeholder="Capacidad máxima"
                        value="{{ old('capacity', $meeting->capacity ?? '0') }}" required>
                    <div class="invalid-feedback">
                        {{ $errors->first('capacity') ?: 'Ingrese una capacidad válida.' }}
                    </div>
                </div>

                <!-- Monto de la cuota -->
                <div class="col-md-2 d-flex align-items-center">
                    <label for="fee_amount" class="col-form-label">Monto de la Cuota:</label>
                </div>
                <div class="col-md-4">
                    <input type="number" step="0.01"
                        class="form-control form-control-sm {{ $errors->has('fee_amount') ? 'is-invalid' : '' }}"
                        id="fee_amount" name="fee_amount" placeholder="Monto de la cuota"
                        value="{{ old('fee_amount', $meeting->fee_amount ?? '0.0') }}" required>
                    <div class="invalid-feedback">
                        {{ $errors->first('fee_amount') ?: 'Ingrese un monto válido.' }}
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
            <button type="button" class="btn btn-default btn-xs float-right" onclick="resetForm(event)" data-redirect="{{ route('admin.meetings.index') }}">Cancelar</button>
        </div>
    </form>
</div>