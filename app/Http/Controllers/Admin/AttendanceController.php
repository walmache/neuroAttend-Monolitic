<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{

    public function index(Meeting $meeting)
    {
        try {
            $roleId = 4; // ID del rol "Usuarios" o "Participante"

            // Obtener usuarios que pertenecen a la organización y tienen el rol con ID 4 en Spatie
            $users = User::whereHas('roles', function ($query) use ($roleId) {
                $query->where('id', $roleId);
            })
                ->where('organization_id', $meeting->organization_id)
                ->get();

            $attendances = Attendance::where('meeting_id', $meeting->id)->pluck('user_id')->toArray();

            $users = $users->map(function ($record) use ($attendances, $meeting) {
                return [
                    'id' => $record->id,
                    'name' => $record->name,
                    'email' => $record->email,
                    'organization' => $record->organization->name ?? 'N/A',
                    'identification' => $record->identification,
                    'login' => $record->login,
                    'photo' => $record->photo,
                    'is_present' => in_array($record->id, $attendances)
                        ? '<input type="checkbox" checked disabled>'
                        : '<input type="checkbox" class="mark-attendance" 
                            data-user-id="' . $record->id . '" 
                            data-meeting-id="' . $meeting->id . '" 
                            data-user-name="' . $record->name . '" 
                            data-meeting-name="' . $meeting->description . '"
                        >'
                ];
            });



            return view('admin.attendance.index', compact('meeting', 'users'));
        } catch (\Exception $e) {
            Log::error('Error al listar asistentes: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al obtener los asistentes para la reunión:' . $meeting->description);
        }
    }

    public function store(Request $request, Meeting $meeting, User $user)
    {
        try {

            // Crear el registro en la base de datos
            Attendance::create([
                'meeting_id' => $meeting->id,
                'user_id' => $user->id,
                'attended' => true,
                'status' => 1,
                'created_by' => Auth::id(),
                'signature' => $request->input('signature'),
            ]);

            // Responder dependiendo del tipo de solicitud
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Asistencia registrada correctamente.']);
            } else {
                return redirect()->route('admin.meetings.attendances.index', $meeting->id)->with('success', 'Usuario agregado a la reunión.');
            }
        } catch (\Exception $e) {
            Log::error('Error al agregar usuario a la reunión: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Error al registrar asistencia.', 'error' => $e->getMessage()], 500);
            } else {
                return back()->with('error', 'Error al agregar usuario: ' . $e->getMessage());
            }
        }
    }


    public function update(Request $request, Attendance $attendance)
    {
        try {
            $attendance->update([
                'attended' => $request->attended,
                'signature' => $request->signature,
                'notes' => $request->notes,
                'status' => $request->status
            ]);

            return redirect()->route('meetings.attendances.index', $attendance->meeting_id)
                ->with('success', 'Asistencia actualizada.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar asistencia: ' . $e->getMessage());
            return back()->with('error', 'Error al actualizar asistencia.');
        }
    }

    public function destroy(Attendance $attendance)
    {
        try {
            $attendance->update(['status' => !$attendance->status]);
            $message = $attendance->status ? 'Asistencia reactivada' : 'Asistencia inactivada';

            return redirect()->route('meetings.attendances.index', $attendance->meeting_id)
                ->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Error al cambiar el estado de la asistencia: ' . $e->getMessage());
            return back()->with('error', 'Error al actualizar el estado.');
        }
    }
}
