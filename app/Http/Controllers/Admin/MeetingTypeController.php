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
        $user = Auth::user();
        $canViewAll = in_array($user->role, ['Administrador', 'Moderador']);
        $canViewAll=1;

        $meetingTypes = $canViewAll ? MeetingType::all() : MeetingType::where('status', 1)->get();

        $meetingTypes = $meetingTypes->map(function ($record) {
            return [
                'id' => $record->id,
                'name' => $record->name,
                'description' => $record->description,
                'actions' => '
                <div class="btn-group btn-group-sm" role="group" aria-label="Input group">
                    <div class="d-flex justify-content-around">
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
                                class="btn btn-xs btn-warning ' . ($record->status ? 'btn-delete' : 'btn-activate') . '" 
                                data-toggle="tooltip" 
                                title="' . ($record->status ? 'Inactivar' : 'Reactivar') . '"
                                data-status="' . $record->status . '" 
                                data-container=".content">
                                <i class="fa ' . ($record->status ? 'fa-trash' : 'fa-check') . '"></i>
                            </button>
                        </form>
                    </div>
                </div>'
            ];
        });
                
        return view('admin.meeting-types.index', compact('meetingTypes'));
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

    public function show(MeetingType $meetingType)
    {
        //
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