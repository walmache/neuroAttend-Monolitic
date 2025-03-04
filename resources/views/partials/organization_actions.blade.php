<div class="d-flex justify-content-around">
    <!-- Editar -->
    <a href="{{ route('organizations.edit', $org->id) }}" class="btn btn-warning btn-xs"  data-toggle="tooltip" title="Editar">
        <i class="fa fa-edit"></i>
    </a>
    
    <!-- Eliminar -->
    <form action="{{ route('organizations.destroy', $org->id) }}" 
          method="POST" 
          style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar" onclick="return confirm('¿Eliminar organización?')">
            <i class="fa fa-trash"></i>
        </button>
    </form>
    
    <!-- Detalles -->
    <a href="{{ route('organizations.show', $org->id) }}" class="btn btn-info btn-xs" data-toggle="tooltip" title="Ver Detalles">
        <i class="fa fa-users"></i>
    </a>
</div>

<div class="d-flex justify-content-around">
        <!-- Botón de Editar -->
        <a href="{{route('organizations.edit', $org->id)}}" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Editar">
            <i class="fa fa-edit"></i>
        </a>

        <!-- Formulario de Eliminar -->
        <form action="{{route('organizations.destroy', $org->id)}}" method="POST" style="display:inline;">csrf_field() . method_field("DELETE") . '
            <button type="submit" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar"> 
                <i class="fa fa-trash"></i>  
            </button>
        </form>

        <!-- Botón de Ver Usuarios -->
        <a href="' . route("organizations.show", $org->id) . '" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Ver Usuarios"> 
            <i class="fa fa-users"></i>  
        </a>
    </div>