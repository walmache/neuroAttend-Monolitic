@php
$formTitle = (isset($user) ? 'Editar Usuario' : 'Nuevo Usuario');
$formTitle .= (!empty($organization) && isset($organization->id) ? ' - ' . $organization->name : '');
$formAction = isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store');
if (!empty($organization) && isset($organization->id))
    session()->flash('organization', $organization)
@endphp
<div class="card card-secondary">
    <div class="card-header">
        <h6 class="card-title">{{ $formTitle }}</h6>
    </div>
    <form id="userForm" method="POST" action="{{ $formAction }}" enctype="multipart/form-data" novalidate>
        @csrf
        @if(isset($user))
        @method('PUT')
        @endif
        <div class="card-body">
            <!-- Organización y Rol -->
            <div class="row">
                <div class="col-md-2 d-flex align-items-center">
                    <label for="organization_id" class="col-form-label">Organización:</label>
                </div>
                <div class="col-md-4">
                    <select id="organization_id" name="organization_id" class="form-control form-control-sm select2 {{ $errors->has('organization_id') ? 'is-invalid' : '' }}">
                        @if (isset($organization) && $organization && $organization->id)
                        <option value="{{ $organization->id }}" selected>{{ $organization->name }}</option>
                        @else
                        <option value="">Seleccione una organización</option>
                        @foreach($organizations as $org)
                        <option value="{{ $org->id }}" {{ isset($user) && $user->organization_id == $org->id ? 'selected' : '' }}>
                            {{ $org->name }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                    @error('organization_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 d-flex align-items-center">
                    <label for="role_id" class="col-form-label">Rol:</label>
                </div>
                <div class="col-md-4">
                    <select id="role_id" name="role_id" class="form-control form-control-sm select2 {{ $errors->has('role_id') ? 'is-invalid' : '' }}" required>
                        <option value="">Seleccione un rol</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ isset($user) && $user->hasRole($role->name) ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('role_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <!-- Nombre y Usuario -->
            <div class="row mt-2">
                <div class="col-md-2 d-flex align-items-center">
                    <label for="name" class="col-form-label">Nombre:</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" required minlength="3" maxlength="255"
                        value="{{ old('name', $user->name ?? '') }}">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 d-flex align-items-center">
                    <label for="login" class="col-form-label">Username:</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm {{ $errors->has('login') ? 'is-invalid' : '' }}" id="login" name="login" required minlength="3" maxlength="255"
                        value="{{ old('login', $user->login ?? '') }}">
                    @error('login')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <!-- Identificación y Email -->
            <div class="row mt-2">
                <div class="col-md-2 d-flex align-items-center">
                    <label for="identification" class="col-form-label">Identificación:</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm {{ $errors->has('identification') ? 'is-invalid' : '' }}" id="identification" name="identification" maxlength="100"
                        value="{{ old('identification', $user->identification ?? '') }}">
                    @error('identification')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 d-flex align-items-center">
                    <label for="email" class="col-form-label">Email:</label>
                </div>
                <div class="col-md-4">
                    <input type="email" class="form-control form-control-sm {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email" required maxlength="255"
                        value="{{ old('email', $user->email ?? '') }}">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <!-- Contraseña y Confirmación -->
            <div class="row mt-2">
                <div class="col-md-2 d-flex align-items-center">
                    <label for="password" class="col-form-label">Contraseña:</label>
                </div>
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <input type="password" class="form-control form-control-sm {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password" name="password" minlength="8">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary btn-sm toggle-password" type="button" data-target="password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-center">
                    <label for="password_confirmation" class="col-form-label">Confirmar:</label>
                </div>
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <input type="password" class="form-control form-control-sm" id="password_confirmation" name="password_confirmation" minlength="8">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary btn-sm toggle-password" type="button" data-target="password_confirmation">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Teléfono y Foto -->
            <div class="row mt-2">
                <div class="col-md-2 d-flex align-items-center">
                    <label for="photo" class="col-form-label">Foto:</label>
                </div>
                <div class="col-md-4">
                    <div class="input-group input-group-sm ">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo" name="photo" accept="image/*">
                            <label class="custom-file-label" for="photo"></label>
                        </div>
                    </div>
                    <small class="text-muted">Se permiten archivos JPEG, PNG, JPG y GIF.</small>
                    @error('photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 d-flex align-items-center">
                    <label for="phone" class="col-form-label">Teléfono:</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm {{ $errors->has('phone') ? 'is-invalid' : '' }}" id="phone" name="phone" maxlength="20"
                        value="{{ old('phone', $user->phone ?? '') }}">
                    @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            @if(isset($user) && $user->photo)
            <div class="mt-2 col-md-6">
                <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto del usuario" class="img-fluid border border-primary img-thumbnail d-block mx-auto" style="max-width: 150px;">
            </div>
            @endif
            <div class="card-footer">
                <button type="submit" class="btn btn-info btn-xs" id="submitBtn">Guardar</button>
                <a href="{{ isset($organization) && $organization->id ? route('admin.organizations.users.index', $organization->id) : route('admin.users.index') }}"
                    class="btn btn-default btn-xs float-right">
                    Cancelar
                </a>
            </div>
        </div>
    </form>
</div>
@section('css')
<style type="text/css">
    .custom-file-label::after {
        content: "\f07c" !important;
        font-family: "Font Awesome 5 Free" !important;
        font-weight: 900 !important;
    }

    /* Ajustar altura del componente de archivo */
    .custom-file {
        height: auto;
    }

    .custom-file-input,
    .custom-file-label {
        height: calc(1.5em + 0.5rem + 2px) !important;
        /* Misma altura que form-control-sm */
        padding: 0.25rem 0.5rem !important;
        line-height: 1.5 !important;
    }

    .custom-file-label::after {
        height: calc(1.5em + 0.5rem) !important;
        padding: 0.25rem 0.5rem !important;
        line-height: 1.5 !important;
    }
</style>
@stop