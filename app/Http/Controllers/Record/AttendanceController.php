<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Meeting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    // 📌 Mostrar selección de reunión y usuario con firma en la misma vista
    public function index()
    {
        $meetings = Meeting::where('status', 1)->get();
        $users = User::where('status', 1)->get();

        return view('record.attendance.index', compact('meetings', 'users'));
    }

    // 📌 Guardar firma y asistencia
    public function store(Request $request)
    {
        $request->validate([
            'meeting_id' => 'required|exists:meetings,id',
            'user_id' => 'required|exists:users,id',
            'signature' => 'required|string',
        ], [
            'meeting_id.required' => 'Debe seleccionar una reunión.',
            'meeting_id.exists' => 'La reunión seleccionada no es válida.',
            'user_id.required' => 'Debe seleccionar un usuario.',
            'user_id.exists' => 'El usuario seleccionado no es válido.',
            'signature.required' => 'La firma es obligatoria.',
        ]);

        try {
            $attendance = Attendance::firstOrNew([
                'meeting_id' => $request->meeting_id,
                'user_id' => $request->user_id,
            ]);

            $attendance->created_by = Auth::id();
            $attendance->attended = true;
            $attendance->status = 1;
            $attendance->signature = $request->signature;
            $attendance->save();

            return redirect()->route('record.attendance.index')
                ->with('success', 'Asistencia registrada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al registrar asistencia: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error al registrar la asistencia.']);
        }
    }
}
