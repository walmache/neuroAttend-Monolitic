<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Organization;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{
    public function __construct()
    {
        // Aplicar permisos a cada acción
        //$this->middleware('permission:ver usuarios')->only('index', 'indexByOrganization');
        // $this->middleware('permission:crear usuarios')->only(['create', 'store', 'createForOrganization', 'storeForOrganization']);
        // $this->middleware('permission:editar usuarios')->only(['edit', 'update']);
        // $this->middleware('permission:eliminar usuarios')->only('destroy');
        // $this->middleware('permission:cambiar contraseña')->only(['showChangePasswordForm', 'updatePassword']);
        // $this->middleware('permission:ver historial reuniones')->only('meetingsHistory');
    }

    public function index(Organization $organization)
    {
        try {
            $usersQuery = User::with(['organization', 'roles']);
            $route = "admin.users.edit";
            if ($organization && $organization->id) {
                $usersQuery->where('organization_id', $organization->id);
                $route = "admin.organizations.users.edit";
            }
            $users = $usersQuery->get();
            $users = $users->map(function ($record) use ($route, $organization) {
                return [
                    'id' => $record->id,
                    'name' => $record->name,
                    'email' => $record->email,
                    'organization' => $record->organization->name ?? 'N A',
                    'role' => $record->getRoleNames()->first() ?? 'N A',
                    'identification' => $record->identification,
                    'photo' => $record->photo,
                    'login' => $record->login,
                    'actions' => '                
                        <div class="btn-group btn-group-xs" role="group">
                            <!-- Botón Editar -->
                            <a href="' . route($route, ($organization && $organization->id) ? [$organization, $record->id] : [$record->id]) . '" 
                                class="btn btn-primary btn-xs"
                                data-toggle="tooltip" 
                                data-placement="top"
                                data-container=".content"
                                title="Editar Usuario">
                                <i class="fa fa-edit"></i>
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
                        </div>'
                ];
            });
            return view('admin.users.index', compact('users', 'organization'));
        } catch (\Exception $e) {
            Log::error('Error al listar usuarios para : ' . $organization->name . " " . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al obtener los usuarios.');
        }
    }

    public function create(Organization $organization)
    {
        $organizations = Organization::all();
        $roles = Role::all();
        return view('admin.users.create', compact('organizations', 'roles', 'organization'));
    }

    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($request->password);
        $validated['created_by'] = Auth::id();
        if ($request->hasFile('photo'))
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        try {
            $user = User::create($validated);
            if ($request->has('role_id')) {
                $role = Role::find($request->role_id);
                if ($role)
                    $user->syncRoles($role->name);
            }
            if (session()->has('organization')) 
                return redirect()->route('admin.organizations.users.index', session('organization'))->with('success', 'Usuario creado con éxito');
            return redirect()->route('admin.users.index')->with('success', 'Usuario creado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear usuario: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Error al guardar los datos ' . $e->getMessage()]);
        }
    }

    public function edit(Organization $organization, User $user)
    {
        $organizations = Organization::all();
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'organizations', 'roles', 'organization'));
    }

    public function update(UserRequest $request, User $user) //Organization $organization,
    {
        try {
            $validated = $request->validated();
            if ($request->filled('password')) {
                $validated['password'] = Hash::make($request->password);
            } else {
                unset($validated['password']); // No actualizar si no se envía
            }
            if ($request->hasFile('photo')) {
                if ($user->photo && Storage::exists('public/' . $user->photo)) {
                    Storage::delete('public/' . $user->photo);
                }
                $validated['photo'] = $request->file('photo')->store('photos', 'public');
            }
            $user->update($validated);
            if ($request->has('role_id')) {
                $role = Role::find($request->role_id); // Busca el rol por ID
                if ($role) {
                    $user->syncRoles($role->name); // Asigna el rol por nombre
                }
            }
            if (session()->has('organization')) 
                return redirect()->route('admin.organizations.users.index', session('organization'))->with('success', 'Usuario actualizado con éxito');
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

    public function meetingsHistory(User $user)
    {
        $attendedMeetings = $user->meetings()->wherePivot('attended', true)->get();
        $pendingMeetings = $user->meetings()->wherePivot('attended', false)->get();

        return view('admin.users.meetings-history', compact('user', 'attendedMeetings', 'pendingMeetings'));
    }
}
