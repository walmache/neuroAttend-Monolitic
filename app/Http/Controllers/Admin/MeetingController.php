<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\Organization;
use App\Models\MeetingType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MeetingRequest;

class MeetingController extends Controller
{
    public function index(MeetingType $meetingType)
    {
        try {
            // Construir la consulta base con relaciones
            $meetingsQuery = Meeting::with(['organization', 'meetingType', 'createdBy']);
            // Definir la ruta base para el botón de edición
            $route = "admin.meetings.edit";

            // Si hay un MeetingType, filtrar las reuniones por ese tipo
            if ($meetingType && $meetingType->id) {
                $meetingsQuery->where('meeting_type_id', $meetingType->id);
                $route = "admin.meeting-types.meetings.edit"; // Ruta específica si accede desde un tipo de reunión
            }

            // Obtener reuniones
            $meetings = $meetingsQuery->get();

            $meetings = $meetings->map(function ($record) use ($route, $meetingType) {
                return [
                    'id' => $record->id,
                    'organization' => $record->organization->name,
                    'meeting_type' => $record->meetingType->name,
                    'datetime' => $record->datetime,
                    'location' => $record->location,
                    'description' => $record->description,
                    'status' => $record->status ? 'Activo' : 'Inactivo',
                    'actions' => '
                        <div class="btn-group btn-group-xs" role="group">
                            <!-- Botón Editar -->
                            <a href="' . route($route, ($meetingType && $meetingType->id) ? [$meetingType, $record->id] : [$record->id]) . '" 
                                class="btn btn-primary btn-xs"
                                data-toggle="tooltip" 
                                data-placement="top"
                                data-container=".content"
                                title="Editar">
                                <i class="fa fa-edit"></i>
                            </a>
                            <!-- Botón Ver Participantes -->
                            <a href="' . route("admin.meetings.attendances.index", $record->id) . '"
                                class="btn btn-info btn-xs"
                                data-toggle="tooltip" 
                                data-placement="top"
                                data-container=".content"
                                title="Participantes">
                                <i class="fa fa-users"></i>
                            </a>
                            <!-- Botón Eliminar -->
                            <form action="' . route("admin.meetings.destroy", $record->id) . '" method="POST" class="d-inline delete-form">
                                ' . csrf_field() . method_field("DELETE") . '
                                <button type="submit" class="btn btn-danger btn-xs btn-delete"
                                    data-toggle="tooltip" 
                                    data-placement="top"
                                    data-container=".content"
                                    title="Eliminar">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>'
                ];
            });
            return view('admin.meetings.index', compact('meetings','meetingType'));
        } catch (\Exception $e) {
            Log::error('Error al listar reuniones para : ' . ($meetingType->name ?? 'todas') . " - " . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al obtener las reuniones.');
        }
    }

    public function create(MeetingType $meetingType)
    {
        $organizations = Organization::all();
        $meetingTypes = MeetingType::all();
        return view('admin.meetings.create', compact('organizations', 'meetingTypes','meetingType'));
    }

    public function store(MeetingRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = Auth::id();
        try {
            //dd($validated);
            Meeting::create($validated);
            return redirect()->route('admin.meetings.index')->with('success', 'Reunión creada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear reunión: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Error al guardar los datos']);
        }
    }

    public function edit(Meeting $meeting)
    {
        $organizations = Organization::all();
        $meetingTypes = MeetingType::all();
        return view('admin.meetings.edit', compact('meeting', 'organizations', 'meetingTypes'));
    }

    public function update(MeetingRequest $request, Meeting $meeting)
    {
        try {
            $meeting->update($request->validated());
            return redirect()->route('admin.meetings.index')->with('success', 'Reunión actualizada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar reunión: ' . $e->getMessage());
            return back()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    public function destroy(Meeting $meeting)
    {
        try {
            $meeting->update(['status' => !$meeting->status]);
            $message = $meeting->status ? 'Reunión reactivada' : 'Reunión inactivada';
            return redirect()->route('admin.meetings.index')->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Error al cambiar el estado de la reunión: ' . $e->getMessage());
            return back()->with('error', 'Error al actualizar el estado: ' . $e->getMessage());
        }
    }
}
