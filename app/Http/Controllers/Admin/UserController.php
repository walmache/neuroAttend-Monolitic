<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Organization;
use App\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $canViewAll = in_array($user->role, ['Administrador', 'Moderador']);
        $canViewAll = 1;

        $users = User::with(['organization', 'role'])->get();

        $users = $users->map(function ($record) {
            return [
                'id' => $record->id,
                'name' => $record->name,
                'email' => $record->email,
                'organization' => $record->organization->name ?? 'Sin Organización',
                'role' => $record->role->name ?? 'Sin Rol',
                'identification' => $record->identification,
                'photo' => $record->photo,
                'login' => $record->login,
                'actions' => '
                
                <div class="btn-group btn-group-sm" role="group" aria-label="Input group">
                    <div class="d-flex justify-content-around">
                        <!-- Botón Editar -->
                        <a href="' . route("admin.users.edit", $record->id) . '" 
                            class="btn btn-primary btn-xs"
                            data-toggle="tooltip" 
                            data-placement="top"
                            data-container=".content"
                            title="Editar Usuario">
                            <i class="fa fa-edit"></i>
                        </a>

                        <!-- Botón Cambiar Contraseña -->
                        <a href="' . route("admin.users.change-password", $record->id) . '"
                            class="btn btn-warning btn-xs"
                            data-toggle="tooltip" 
                            data-placement="top"
                            data-container=".content"
                            title="Cambiar Contraseña">
                            <i class="fa fa-key"></i>
                        </a>

                        <!-- Botón Historial de Reuniones -->
                        <a href="' . route("admin.users.meetings-history", $record->id) . '"
                            class="btn btn-info btn-xs"
                            data-toggle="tooltip" 
                            data-placement="top"
                            data-container=".content"
                            title="Ver Historial de Reuniones">
                            <i class="fa fa-calendar"></i>
                        </a>

                        <!-- Botón Eliminar -->
                        <form action="' . route("admin.users.destroy", $record->id) . '" 
                            method="POST" class="d-inline delete-form">
                            ' . csrf_field() . method_field("DELETE") . '
                            <button type="submit" class="btn btn-danger btn-xs btn-delete"
                                data-toggle="tooltip" 
                                data-placement="top"
                                data-container=".content"
                                title="Eliminar Usuario">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>'
            ];
        });

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $organizations = Organization::all();
        $roles = Role::all();
        return view('admin.users.create', compact('organizations', 'roles'));
    }

    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($request->password);
        $validated['created_by'] = Auth::id();

        try {
            User::create($validated);
            return redirect()->route('admin.users.index')->with('success', 'Usuario creado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear usuario: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Error al guardar los datos ' . $e->getMessage()]);
        }
    }

    public function edit(User $user)
    {
        $organizations = Organization::all();
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'organizations', 'roles'));
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            $validated = $request->validated();

            if ($request->filled('password')) {
                $validated['password'] = Hash::make($request->password);
            } else {
                unset($validated['password']); // No actualizar si no se envía
            }

            $user->update($validated);
            return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar usuario: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error al actualizar los datos']);
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->update(['status' => !$user->status]);
            return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar usuario: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error al eliminar el usuario']);
        }
    }

    public function showChangePasswordForm(User $user)
    {
        return view('admin.users.change-password', compact('user'));
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            return redirect()->route('admin.users.index')->with('success', 'Contraseña actualizada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al cambiar la contraseña: ' . $e->getMessage());
            return back()->withErrors(['error' => 'No se pudo cambiar la contraseña.']);
        }
    }

    public function meetingsHistory(User $user)
    {
        $attendedMeetings = $user->meetings()->wherePivot('attended', true)->get();
        $pendingMeetings = $user->meetings()->wherePivot('attended', false)->get();

        return view('admin.users.meetings-history', compact('user', 'attendedMeetings', 'pendingMeetings'));
    }
}
