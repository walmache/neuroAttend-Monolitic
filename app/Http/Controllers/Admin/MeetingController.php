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
    public function index()
    {
        $user = Auth::user();
        $canViewAll = in_array($user->role, ['Administrador', 'Moderador']);
        $canViewAll = 1;

        $meetings = $canViewAll ? Meeting::with(['organization', 'meetingType', 'createdBy'])->get() : Meeting::where('status', 1)->with(['organization', 'meetingType', 'creator'])->get();

        $meetings = $meetings->map(function ($record) {
            return [
                'id' => $record->id,
                'organization' => $record->organization->name,
                'meeting_type' => $record->meetingType->name,
                'datetime' => $record->datetime,
                'location' => $record->location,
                'description' => $record->description,
                'status' => $record->status ? 'Activo' : 'Inactivo',
                'actions' => '
                <div class="btn-group btn-group-sm" role="group" aria-label="Input group">
                    <div class="d-flex justify-content-around">
                        <a href="' . route("admin.meetings.edit", $record->id) . '" 
                            class="btn btn-primary btn-xs" 
                            data-toggle="tooltip" 
                            data-placement="top" 
                            title="Editar" data-container=".content">
                            <i class="fa fa-edit"></i>  
                        </a>
                        <form action="' . route("admin.meetings.destroy", $record->id) . '" method="POST" class="d-inline toggle-status-form">
                            ' . csrf_field() . method_field("DELETE") . '
                            <button type="submit" 
                                class="btn btn-xs btn-warning ' . ($record->status ? 'btn-delete' : 'btn-activate') . '" 
                                data-toggle="tooltip" 
                                title="' . ($record->status ? 'Inactivar' : 'Reactivar') . '"
                                data-status="' . $record->status . '" 
                                data-container=".content">
                                <i class="fa ' . ($record->status ? 'fa-trash' : 'fa-check') . '"></i>
                            </button>
                        </form>
                        <!-- Botón de Ver Usuarios -->
                        <a href="' . route("admin.organizations.show", $record->id) . '" 
                            class="btn btn-info btn-xs" 
                            data-toggle="tooltip" 
                            data-placement="top" 
                            title="Ver Asistentes" data-container=".content"> 
                            <i class="fa fa-users"></i>  
                        </a>
                    </div>
                </div>'
            ];
        });
        
        return view('admin.meetings.index', compact('meetings'));
    }

    public function create()
    {
        $organizations = Organization::all();
        $meetingTypes = MeetingType::all();
        return view('admin.meetings.create', compact('organizations', 'meetingTypes'));
    }

    public function store(MeetingRequest $request)
    {
        

        $validated = $request->validated();
        $validated['created_by'] = Auth::id();
        try {
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
