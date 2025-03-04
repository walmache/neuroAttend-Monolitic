@extends('layouts.app')

@section('title', 'Organizaciones')

{{-- section('content_header_title', 'Gestión de Organizaciones') --}}

@section('content_body')
<div class="row col d-flex justify-content-center pt-2">
    <div class="col-8">
        <div class="card card-info">
            <div class="card-header">
                <h6 class="card-title">Nueva Organización</h6>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal">
                <div class="card-body">
                    <div class="row">
                        <!-- Nombre -->
                        <div class="col-md-2 d-flex align-items-center">
                            <label for="nombre" class="col-form-label">Nombre:</label>
                        </div>
                        <div class="col-md-4">
                            <input
                                type="text"
                                class="form-control form-control-sm"
                                id="nombre"
                                name="nombre"
                                placeholder="Nombre"
                                required />
                        </div>
                        <!-- Dirección -->
                        <div class="col-md-2 d-flex align-items-center">
                            <label for="direccion" class="col-form-label">Dirección:</label>
                        </div>
                        <div class="col-md-4">
                            <input
                                type="text"
                                class="form-control form-control-sm"
                                id="direccion"
                                name="direccion"
                                placeholder="Dirección"
                                required />
                        </div>
                    </div>
                    <div class="row ">
                        <!-- Representante -->
                        <div class="col-md-2 d-flex align-items-center">
                            <label for="representante" class="col-form-label">Representante:</label>
                        </div>
                        <div class="col-md-4">
                            <input
                                type="text"
                                class="form-control form-control-sm"
                                id="representante"
                                name="representante"
                                placeholder="Representante"
                                required />
                        </div>
                        <!-- Teléfono -->
                        <div class="col-md-2 d-flex align-items-center">
                            <label for="telefono" class="col-form-label">Teléfono:</label>
                        </div>
                        <div class="col-md-4">
                            <input
                                type="tel"
                                class="form-control form-control-sm"
                                id="telefono"
                                name="telefono"
                                placeholder="Teléfono"
                                required />
                        </div>
                    </div>
                    <div class="row mb-1">
                        <!-- Email -->
                        <div class="col-md-2 d-flex align-items-center">
                            <label for="email" class="col-form-label">Email:</label>
                        </div>
                        <div class="col-md-4">
                            <input
                                type="email"
                                class="form-control form-control-sm"
                                id="email"
                                name="email"
                                placeholder="Email"
                                required />
                        </div>
                    </div>
                    <div class="row">
                        <!-- Observaciones -->
                        <div class="col-md-2 d-flex align-items-start">
                            <label for="observaciones" class="col-form-label">Observaciones:</label>
                        </div>
                        <div class="col-md-10">
                            <textarea
                                class="form-control form-control-sm"
                                id="observaciones"
                                name="observaciones"
                                rows="3"
                                placeholder="Observaciones"></textarea>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer p-2">
                    <button type="submit" class="btn btn-info btn-xs" [disabled]="orgForm.invalid">
                        Guardar
                    </button>
                    <button type="button" class="btn btn-default btn-xs float-right">Cancelar</button>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</div>
@endsection
