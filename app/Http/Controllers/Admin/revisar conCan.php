use Illuminate\Support\Facades\Auth;
// ...

class OrganizationController extends Controller
{
    public function index()
    {
        // **1. Filtrar organizaciones según el rol del usuario:**
        // Un administrador ve todas las organizaciones; otros roles ven solo las asignadas.
        $user = Auth::user();
        $organizationsQuery = Organization::query();
        if (!$user->hasRole('Admin')) {
            // Por ejemplo, si no es Admin, mostrar solo la organización creada por el usuario (ajustar según lógica de la app)
            $organizationsQuery->where('created_by', $user->id);
        }
        $organizations = $organizationsQuery->get();

        // **2. Mapear datos de organizaciones con mínima lógica en la función anónima:**
        $organizationsData = $organizations->map(function ($org) {
            return [
                'id'            => $org->id,
                'name'          => $org->name,
                'address'       => $org->address,
                'representative'=> $org->representative,
                'phone'         => $org->phone,
                'email'         => $org->email,
                'notes'         => $org->notes,
                // Llamada a función separada para generar acciones:
                'actions'       => $this->getActionButtons($org)
            ];
        });

        // **3. Retornar datos a la vista (evitando HTML en el controlador):**
        return view('admin.organizations.index', [
            'organizations' => $organizationsData
        ]);
    }

    /**
     * Genera la lista de acciones (botones) permitidas para una organización dada.
     * Se devuelve una estructura de datos que la vista Blade utilizará para renderizar HTML.
     */
    private function getActionButtons(Organization $org)
    {
        $actions = [];

        // Botón Editar (si el usuario tiene permiso de edición)
        if (Auth::user()->can('update', $org)) {
            $actions[] = [
                'route' => route('organizations.edit', $org->id),
                'label' => 'Editar',
                'icon'  => 'fa-edit',  // por ejemplo, clase FontAwesome
            ];
        }

        // Botón Activar/Desactivar según el estado actual de la organización
        if ($org->is_active) {
            $actions[] = [
                'route' => route('organizations.deactivate', $org->id),
                'label' => 'Desactivar',
                'icon'  => 'fa-ban',
            ];
        } else {
            $actions[] = [
                'route' => route('organizations.activate', $org->id),
                'label' => 'Activar',
                'icon'  => 'fa-check',
            ];
        }

        // Botón Ver Usuarios (siempre disponible, por ejemplo, para ver detalle de la organización)
        $actions[] = [
            'route' => route('organizations.show', $org->id),
            'label' => 'Ver Usuarios',
            'icon'  => 'fa-users',
        ];

        return $actions;
    }
}

