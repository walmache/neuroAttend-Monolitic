@extends('adminlte::page')

@section('title', config('adminlte.title'))

@section('content_header')
@hasSection('content_header_title')
<h6>@yield('content_header_title')</h6>
@hasSection('content_header_subtitle')
<small>@yield('content_header_subtitle')</small>
@endif
@endif
@endsection

@section('content')
@yield('content_body')
@endsection

@section('footer')
<strong>© {{ date('Y') }} <a href="https://neurotic.com">NeuroTIC</a></strong>. Todos los derechos reservados.
<div class="float-right d-none d-sm-inline-block"><b>Powered by</b> NeuroTIC</div>
@endsection

@push('js')
<script>
    toastr.options.closeButton = true; // Mostrar botón de cerrar
    toastr.options.timeOut = 5000; // Sin auto-cierre (duración infinita)
    toastr.options.extendedTimeOut = 0; // Mantener sin cerrarse incluso al pasar el mouse
    toastr.options.closeHtml = '<button><i class="fa fa-times-circle"></i></button>';

    @session('success')
        toastr.success(@json($value)); // Mensaje de éxito en verde
    @endsession

    @session('error')
        toastr.error(@json($value)); // Mensaje de error en rojo
    @endsession

    @session('warning')
        toastr.warning(@json($value)); // Mensaje de advertencia en amarillo
    @endsession

    @session('info')
        toastr.info(@json($value)); // Mensaje informativo en azul
    @endsession

    // Mostrar errores de validación
    @if($errors->any())
        @foreach($errors->all() as $error)
            toastr.error(@json($error)); // Cada error aparece en un toast rojo
        @endforeach
    @endif

    $(document).ready(function() {
        $('body').tooltip({
            selector: '[data-toggle="tooltip"],.label',
            boundary: 'window',
        });

        $.extend(true, $.fn.dataTable.defaults, {
            columnDefs: [{
                orderable: false,
                searchable: false,
                className: "text-center",
                targets: -1
            }],
            dom: '<"row" <"col-md-4" B> <"col-md-4 d-flex justify-content-start" l>  <"col-md-4 d-flex justify-content-end" f> > <"row" <"col-12" tr> > <"row" <"col-md-6 d-flex justify-content-start" i> <"col-md-6 d-flex justify-content-end" p> >',
            buttons: {
                buttons: [{
                        extend: 'excel',
                        className: 'bg-success btn-sm label',
                        text: '<i class="far fa-file-excel bg-success"></i>',
                        titleAttr: 'Exportar a Excel',
                    },
                    {
                        extend: 'copy',
                        className: 'bg-secondary btn-sm label',
                        text: '<i class="far fa-copy"></i>',
                        titleAttr: 'Copiar a memoria',
                    },
                    {
                        extend: 'csv',
                        className: 'bg-info btn-sm label',
                        text: '<i class="fas fa-file-csv bg-primary"></i>',
                        titleAttr: 'Exportar a CSV',
                    },
                    {
                        extend: 'pdf',
                        className: 'bg-red btn-sm label',
                        text: '<i class="far fa-file-pdf bg-danger"></i>',
                        titleAttr: 'Exportar a PDF',
                    },
                    {
                        extend: 'print',
                        className: 'bg-primary btn-sm label',
                        text: '<i class="fas fa-print"></i>',
                        titleAttr: 'Imprimir',
                    },
                ]
            },
            responsive: true,
            autoWidth: false,
            language: {
                "url": "/vendor/i18n/Spanish.json"
            },
            paging: true,
            searching: true,
            pagingType: "full_numbers",
            classes: {
                pagination: 'pagination pagination-sm' // Hace los botones más pequeños
            },
            initComplete: function(settings, json) {
                $('.pagination').addClass('pagination-sm');
                // $('.paginate_button').addClass('btn btn-xs btn-default');
            },
            drawCallback: function() {
                $('.paginate_button').removeClass('btn-primary').addClass('btn-default');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const logoutButton = document.getElementById('logoutButton');
        const logoutForm = document.getElementById('logout-form');

        if (logoutButton && logoutForm) {
            // Eliminar el atributo onclick original
            logoutButton.removeAttribute('onclick');

            // Agregar el evento click manualmente
            logoutButton.addEventListener('click', function(event) {
                event.preventDefault(); // Evitar que se envíe el formulario inmediatamente

                // Mostrar la alerta de confirmación
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡Quieres cerrar sesión!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, cerrar sesión',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Si el usuario confirma, enviar el formulario de logout
                        logoutForm.submit();
                    }
                });
            });
        }
    });

    console.log("AdminLTE cargado correctamente");

    // Duración total de la sesión en minutos
    const SESSION_LIFETIME = {{ config('session.lifetime') }};
    // Minutos antes de que expire la sesión para mostrar la advertencia
    const WARNING_BEFORE_EXPIRY = 1; // Ejemplo: 2 minutos antes
    // Calculamos el tiempo en milisegundos
    const warningTime = (SESSION_LIFETIME - WARNING_BEFORE_EXPIRY) * 60 * 1000;

setTimeout(() => {
    Swal.fire({
        title: 'Sesión a punto de expirar',
        text: 'Tu sesión expirará pronto. ¿Deseas mantenerla activa?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Mantener Sesión',
        cancelButtonText: 'Cerrar Sesión',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Opción 1: Renovar la sesión con AJAX (fetch)
            fetch('{{ route("keep-alive") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'ok') {
                        // Opcional: recargar la página para reiniciar el temporizador
                        // o reprogramar un nuevo setTimeout para volver a mostrar la alerta
                        location.reload();
                    }
                })
                .catch(error => console.error('Error al renovar sesión:', error));
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Opción 2: Cerrar sesión de inmediato
            //window.location.href = '{{ route("logout") }}';
            logoutViaPost();
        }
    });
}, warningTime);

// Función para enviar la petición POST
function logoutViaPost() {
    // Obtenemos el token CSRF del meta tag
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch('{{ route("logout") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        // Laravel suele redirigir tras hacer logout. 
        // Si tu controlador no lo hace, puedes forzar la redirección aquí.
        if (response.redirected) {
            // Si Laravel redirige a /login o /, podemos seguir la redirección
            window.location.href = response.url;
        } else {
            // O recargar la página
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Error al cerrar sesión:', error);
        Swal.fire('Error', 'No se pudo cerrar sesión.', 'error');
    });
}  
</script>
@endpush