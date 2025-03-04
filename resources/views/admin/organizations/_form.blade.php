<!-- resources/views/admin/organizations/_form.blade.php -->
@php
    // Si estamos en edición, $organization contendrá los datos. Sino, es nulo.
    $formTitle = isset($organization) ? 'Editar Organización' : 'Nueva Organización';
    // Define la acción y método de formulario según el contexto
    $formAction = isset($organization)? route('admin.organizations.update', $organization->id) : route('admin.organizations.store');
@endphp

<div class="card card-secondary">
    <div class="card-header">
        <h6 class="card-title">{{ $formTitle }}</h6>
    </div>
    <!-- Si es edición, usamos el método PUT o PATCH -->
    <form id="organization" method="POST" action="{{ $formAction }}" novalidate>
        @csrf
        @if(isset($organization))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 d-flex align-items-center">
                    <label for="name" class="col-form-label">Nombre:</label>
                </div>
                <div class="col-md-4">
                    <input type="text"
                           class="form-control form-control-sm {{ $errors->has('name') ? 'is-invalid' : '' }}"
                           id="name" name="name" placeholder="Nombre"
                           minlength="3" maxlength="100"
                           value="{{ old('name', $organization->name ?? '') }}" required>
                    <div class="invalid-feedback">
                        {{ $errors->first('name') ?: 'El nombre es requerido (3-100 caracteres)' }}
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-center">
                    <label for="address" class="col-form-label">Dirección:</label>
                </div>
                <div class="col-md-4">
                    <input type="text"
                           class="form-control form-control-sm {{ $errors->has('address') ? 'is-invalid' : '' }}"
                           id="address" name="address" placeholder="Dirección"
                           minlength="5" maxlength="200"
                           value="{{ old('address', $organization->address ?? '') }}" required>
                    <div class="invalid-feedback">
                        {{ $errors->first('address') ?: 'La dirección debe tener entre 5 y 200 caracteres' }}
                    </div>
                </div>
            </div>
            <!-- Agrega los demás campos de manera similar -->
            <div class="row">
                <div class="col-md-2 d-flex align-items-center">
                    <label for="representative" class="col-form-label">Representante:</label>
                </div>
                <div class="col-md-4">
                    <input type="text"
                           class="form-control form-control-sm {{ $errors->has('representative') ? 'is-invalid' : '' }}"
                           id="representative" name="representative" placeholder="Representante"
                           minlength="3" maxlength="100" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ\s]+"
                           value="{{ old('representative', $organization->representative ?? '') }}" required>
                    <div class="invalid-feedback">
                        {{ $errors->first('representative') ?: 'Nombre del representante requerido (3-100 caracteres)' }}
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-center">
                    <label for="phone" class="col-form-label">Teléfono:</label>
                </div>
                <div class="col-md-4">
                    <input type="tel"
                           class="form-control form-control-sm {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                           id="phone" name="phone" placeholder="Teléfono"
                           pattern="[0-9+\- ]{6,20}"
                           value="{{ old('phone', $organization->phone ?? '') }}" required>
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') ?: 'Teléfono válido (6-20 dígitos, puede incluir + y -)' }}
                    </div>
                </div>
            </div>
            <!-- Continúa con email, notes, etc. -->
            <div class="row mb-1">
                <div class="col-md-2 d-flex align-items-center">
                    <label for="email" class="col-form-label">Email:</label>
                </div>
                <div class="col-md-4">
                    <input type="email"
                           class="form-control form-control-sm {{ $errors->has('email') ? 'is-invalid' : '' }}"
                           id="email" name="email" placeholder="Email" maxlength="100"
                           value="{{ old('email', $organization->email ?? '') }}" required>
                    <div class="invalid-feedback">
                        {{ $errors->first('email') ?: 'Ingrese un correo electrónico válido' }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 d-flex align-items-start">
                    <label for="notes" class="col-form-label">Observaciones:</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control form-control-sm {{ $errors->has('notes') ? 'is-invalid' : '' }}"
                              id="notes" name="notes" rows="3" placeholder="Observaciones" maxlength="500">{{ trim(old('notes', $organization->notes ?? '')) }}</textarea>
                    <div class="invalid-feedback">
                        {{ $errors->first('notes') ?: 'Máximo 500 caracteres permitidos' }}
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
