document.addEventListener('DOMContentLoaded', function() {
    toastr.options.closeButton = true;
    toastr.options.timeOut = 5000;
    toastr.options.extendedTimeOut = 0;
    toastr.options.closeHtml = '<button><i class="fa fa-times-circle"></i></button>';

    if (window.flashMessages) {
        Object.keys(window.flashMessages).forEach(type => {
            showToast(type, window.flashMessages[type]);
        });
    }

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
            pagination: 'pagination pagination-sm'
        },
        initComplete: function(settings, json) {
            $('.pagination').addClass('pagination-sm');
        },
        drawCallback: function() {
            $('.paginate_button').removeClass('btn-primary').addClass('btn-default');
        }
    });

    const logoutButton = document.getElementById('logoutButton');
    const logoutForm = document.getElementById('logout-form');

    if (logoutButton && logoutForm) {
        logoutButton.removeAttribute('onclick');
        logoutButton.addEventListener('click', function(event) {
            event.preventDefault();
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
                    logoutForm.submit();
                }
            });
        });
    }

    console.log("AdminLTE cargado correctamente");

    const SESSION_LIFETIME = window.sessionData.sessionLifetime;
    const WARNING_BEFORE_EXPIRY = 1;
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
                fetch('/keep-alive')
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'ok') {
                            location.reload();
                        }
                    })
                    .catch(error => console.error('Error al renovar sesión:', error));
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                logoutViaPost();
            }
        });
    }, warningTime);

    function logoutViaPost() {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch('/logout', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.redirected) {
                window.location.href = response.url;
            } else {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error al cerrar sesión:', error);
            Swal.fire('Error', 'No se pudo cerrar sesión.', 'error');
        });
    }

    $('.datatable').DataTable();
});

function showToast(type, message) {
    if (type === 'success') toastr.success(message);
    if (type === 'error') toastr.error(message);
    if (type === 'warning') toastr.warning(message);
    if (type === 'info') toastr.info(message);
}
console.log("init.js cargado correctamente");
