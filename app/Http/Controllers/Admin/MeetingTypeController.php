<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MeetingType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MeetingTypeRequest;

class MeetingTypeController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            if ($user->hasRole('SuperAdministrador')) {
                $meetingTypes = MeetingType::all(); // 🔹 SuperAdministrador puede ver todas las organizaciones
            } else {
                abort(403, 'No tienes permiso para ver esta sección.');
            }
            $meetingTypes = $meetingTypes->map(function ($record) {
                return [
                    'id' => $record->id,
                    'name' => $record->name,
                    'description' => $record->description,
                    'actions' => '
                    <div class="btn-group btn-group-xs" role="group">
                        <!-- Botón de Editar -->
                        <a href="' . route("admin.meeting-types.edit", $record->id) . '" 
                            class="btn btn-primary btn-xs" 
                            data-toggle="tooltip" 
                            data-placement="top" 
                            title="Editar" data-container=".content">
                            <i class="fa fa-edit"></i>  
                        </a>
                        <!-- Formulario para Inactivar/Reactivar -->
                        <form action="' . route("admin.meeting-types.destroy", $record->id) . '" method="POST" class="d-inline toggle-status-form">
                            ' . csrf_field() . method_field("DELETE") . '
                            <button type="submit" 
                                class="btn btn-xs '. ($record->status ? 'btn-delete btn-danger' : 'btn-activate btn-warning ') . '"
                                data-toggle="tooltip" 
                                title="' . ($record->status ? 'Inactivar' : 'Reactivar') . '"
                                data-status="' . $record->status . '" 
                                data-container=".content">
                                <i class="fa ' . ($record->status ? 'fa-exclamation-triangle' : 'fa-check'). '"></i>
                            </button>
                        </form>
                        <!-- Botón de Ver Usuarios -->
                        <a href="' . route("admin.meeting-types.meetings.index", $record->id) . '" 
                            class="btn btn-info btn-xs" 
                            data-toggle="tooltip" 
                            data-placement="top" 
                            title="Ver Reuniones" data-container=".content"> 
                            <i class="fa  fa-layer-group"></i>  
                        </a>
                    </div>'
                ];
            });
            return view('admin.meeting-types.index', compact('meetingTypes'));
        } catch (\Exception $e) {
            Log::error('Error al listar tipos de Reuniones : ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al obtener los tipos de reuniones.');
        }
    }

    public function create()
    {
        return view('admin.meeting-types.create');
    }

    public function store(MeetingTypeRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = Auth::id();
        try {
            MeetingType::create($validated);
            return redirect()->route('admin.meeting-types.index')->with('success', 'Tipo de reunión creado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear tipo de reunión: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Error al guardar los datos']);
        }
    }

    public function edit(MeetingType $meetingType)
    {
        return view('admin.meeting-types.edit', compact('meetingType'));
    }

    public function update(MeetingTypeRequest $request, MeetingType $meetingType)
    {
        try {
            $meetingType->update($request->validated());
            return redirect()->route('admin.meeting-types.index')->with('success', 'Tipo de reunión actualizado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar tipo de reunión: ' . $e->getMessage());
            return back()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    public function destroy(MeetingType $meetingType)
    {
        try {
            $meetingType->update(['status' => !$meetingType->status]);
            $message = $meetingType->status ? 'Registro reactivada' : 'Registro inactivada';
            return redirect()->route('admin.meeting-types.index')->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Error al cambiar el estado del tipo de reunión: ' . $e->getMessage());
            return back()->with('error', 'Error al actualizar el estado: ' . $e->getMessage());
        }
    }
}
