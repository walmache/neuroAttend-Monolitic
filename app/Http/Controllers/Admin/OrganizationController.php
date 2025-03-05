<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\OrganizationRequest;
use Illuminate\Support\Facades\Auth;


class OrganizationController extends Controller
{
    public function __construct()
    {
        
        // Aplicar permisos a cada acción
        $this->middleware('permission:ver organizaciones')->only('index');
        $this->middleware('permission:crear organizaciones')->only(['create', 'store']);
        $this->middleware('permission:editar organizaciones')->only(['edit', 'update']);
        $this->middleware('permission:eliminar organizaciones')->only('destroy');
    }

    public function index()
    {
        
        try {
            $user = Auth::user();

            if ($user->hasRole('SuperAdministrador')) {
                $organizations = Organization::all(); // 🔹 SuperAdministrador puede ver todas las organizaciones
            } elseif ($user->hasRole('Administrador')) {
                $organizations = Organization::where('id', $user->organization_id)->get(); // 🔹 Administrador solo ve las organizaciones a las que pertenece
            } else {
                // Si no tiene permiso, devuelve un error 403
                abort(403, 'No tienes permiso para ver esta sección.');
            }
            $organizations = $organizations->map(function ($organization) {
                return [
                    'id' => $organization->id,
                    'name' => $organization->name,
                    'address' => $organization->address,
                    'representative' => $organization->representative,
                    'phone' => $organization->phone,
                    'email' => $organization->email,
                    'notes' => $organization->notes,
                    'actions' => '
                    <div class="btn-group btn-group-sm" role="group" aria-label="Input group">
                        <div class="d-flex justify-content-around">
                            <!-- Botón de Editar -->
                            <a href="' . route("admin.organizations.edit", $organization->id) . '" 
                                class="btn btn-primary btn-xs" 
                                data-toggle="tooltip" 
                                data-placement="top" 
                                title="Editar" data-container=".content">
                                <i class="fa fa-edit"></i>  
                            </a>
                            <!-- Formulario para Inactivar/Reactivar -->
                            <form action="' . route("admin.organizations.destroy", $organization->id) . '" method="POST" class="d-inline toggle-status-form">
                                ' . csrf_field() . method_field("DELETE") . '
                                <button type="submit" 
                                    class="btn btn-xs btn-warning ' . ($organization->status ? 'btn-delete' : 'btn-activate') . '" 
                                    data-toggle="tooltip" 
                                    title="' . ($organization->status ? 'Inactivar' : 'Reactivar') . '"
                                    data-status="' . $organization->status . '" 
                                    data-container=".content">
                                    <i class="fa ' . ($organization->status ? 'fa-trash' : 'fa-check') . '"></i>
                                </button>
                            </form>
                            <!-- Botón de Ver Usuarios -->
                            <a href="' . route("admin.organizations.show", $organization->id) . '" 
                                class="btn btn-info btn-xs" 
                                data-toggle="tooltip" 
                                data-placement="top" 
                                title="Ver Usuarios" data-container=".content"> 
                                <i class="fa fa-users"></i>  
                            </a>
                        </div>
                    </div>'
                ];
            });
            return view('admin.organizations.index', compact('organizations'));
        } catch (\Exception $e) {
            Log::error('Error al listar organizaciones: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al obtener las organizaciones.');
        }
    }

    public function create()
    {
        return view('admin.organizations.create');
    }

    public function store(OrganizationRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = Auth::id();
        try {
            Organization::create($validated);
            return redirect()->route('admin.organizations.index')->with('success', 'Organización creada con exito.');
        } catch (\Exception $e) {
            Log::error('Error al crear organización: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Error al guardar los datos']);
        }
    }

    public function show(Organization $organization)
    {
        return view('admin.organizations.show', compact('organization'));
    }

    public function edit(Organization $organization)
    {
        return view('admin.organizations.edit', compact('organization'));
    }

    public function update(OrganizationRequest $request, Organization $organization)
    {
        $validated = $request->validated();
        try {
            $organization->update($validated);
            return redirect()->route('admin.organizations.index')->with('success', 'Organización actualizada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error actualizando organización: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Error al actualizar los datos.']);
        }
    }

    public function destroy(Organization $organization)
    {
        try {
            $organization->update(['status' => !$organization->status]);
            $message = $organization->status ? 'Organización reactivada' : 'Organización inactivada';
            return redirect()->route('admin.organizations.index')->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Error al cambiar el estado de la organización: ' . $e->getMessage());
            return back()->with('error', 'Error al actualizar el estado: ' . $e->getMessage());
        }
    }
}
