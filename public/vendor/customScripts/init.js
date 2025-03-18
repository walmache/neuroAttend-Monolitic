// init.js
(function() {
    "use strict";
    // =====================================================
    // Función: Inicializar Toastr
    // =====================================================
    function initToastr() {
        toastr.options = {
            closeButton: true,
            timeOut: 5000,          // Cambia a 0 si no deseas auto-cierre
            extendedTimeOut: 0,
            closeHtml: '<button><i class="fa fa-times-circle"></i></button>'
        };
    }
    // =====================================================
    // Función: Mostrar mensajes flash
    // =====================================================
    function showFlashMessages() {
        if (!window.flashMessages) return;
        // Recorrer todos los tipos de mensajes en flashMessages
        Object.keys(window.flashMessages).forEach(function(type) {
            var message = window.flashMessages[type];
            // Gestionar los errores (si el tipo es 'errors')
            if (type === 'errors' && message) {
                // Si es un objeto, recorrer los errores de validación
                Object.values(message).flat().forEach(function(errMsg) {
                    showToast('error', errMsg);
                });
            }
            // Para otros tipos de mensajes como 'success', 'info', 'warning'
            else if (message) {
                showToast(type, message);
            }
        });
    }
    // =====================================================
    // Función: Mostrar un toast según el tipo
    // =====================================================
    function showToast(type, message) {
        const toastTypes = {
            'success': toastr.success,
            'error': toastr.error,
            'warning': toastr.warning,
            'info': toastr.info
        };
        // Si el tipo de mensaje existe en el objeto, se llama la función correspondiente
        if (toastTypes[type]) {
            toastTypes[type](message);
        } else {
            console.log("Tipo de mensaje desconocido: " + type);
        }
    }
    // =====================================================
    // Función: Resetear un formulario genérico
    // =====================================================
    window.resetForm = function(event) {
        const button = event.target.closest('button');
        const redirectUrl = button?.dataset?.redirect;
        if (redirectUrl) {
            window.location.href = redirectUrl;
        } else {
            console.error("No se definió data-redirect en el botón");
        }
        // const form = event.target.closest('form');
        // const formId = form ? form.id : null;
        // if (formId && redirectMap[formId]) {
        //     window.location.href = redirectMap[formId];
        // } else {
        //     console.error("Redirección no definida para el formulario con ID: " + formId);
        // }
        // Si también deseas resetear el formulario, puedes descomentar las siguientes líneas:
        // form.reset();
        // form.classList.remove('was-validated');
        // form.querySelectorAll('.form-control').forEach(element => {
        //     element.classList.remove('is-valid', 'is-invalid');
        // });
        // form.querySelectorAll('.invalid-feedback').forEach(element => {
        //     element.style.display = 'none';
        // });
    }
    // =====================================================
    // Función: Validar un formulario genérico
    // =====================================================
    // function validateForm(form) {
    //     let isValid = true;
    //     form.querySelectorAll('input, textarea, select, input[type="checkbox"]').forEach(element => {
    //         if (!element.checkValidity()) {
    //             isValid = false;
    //         }
    //         element.classList.toggle('is-invalid', !element.checkValidity());
    //         element.classList.toggle('is-valid', element.checkValidity());
    //     });
    //     const submitBtn = form.querySelector('[type="submit"]');
    //     if (submitBtn) submitBtn.disabled = !isValid;
    //     return isValid;
    // }
    // // Validación en tiempo real al escribir en un campo
    // window.validateFormRealTime = function(form) {
    //     // Verificar si el formulario existe antes de continuar
    //     if (!form) {
    //         console.error("Formulario no encontrado.");
    //         return;
    //     }
    //     form.querySelectorAll('input, textarea, select, input[type="checkbox"]').forEach(element => {
    //         element.addEventListener('input', function() {
    //             validateForm(form); // Validar el formulario cada vez que el valor cambie
    //         });
    //         element.addEventListener('blur', function() {
    //             validateForm(form); // Validar el formulario cuando el campo pierda el foco
    //         });
    //     });
    // };

    function validateForm(form) {
        let isValid = true;
        // Validar todos los elementos estándar
        form.querySelectorAll('input, textarea, select, input[type="checkbox"]').forEach(element => {
            if (!element.checkValidity()) {
                isValid = false;
            }
            element.classList.toggle('is-invalid', !element.checkValidity());
            element.classList.toggle('is-valid', element.checkValidity());
            // Agregar lógica específica para select2
            if ($(element).hasClass('select2') && (!element.value || element.value === '')) {
                isValid = false;
                $(element).next('.select2-container').find('.select2-selection').css('border-color', '#dc3545');
            } else if ($(element).hasClass('select2')) {
                $(element).next('.select2-container').find('.select2-selection').css('border-color', '');
            }
        });
        const submitBtn = form.querySelector('[type="submit"]');
        if (submitBtn) submitBtn.disabled = !isValid;
        return isValid;
    }
    // Validación en tiempo real al escribir en un campo
    window.validateFormRealTime = function(form) {
        // Verificar si el formulario existe antes de continuar
        if (!form) {
            console.error("Formulario no encontrado.");
            return;
        }
        form.querySelectorAll('input, textarea, select, input[type="checkbox"]').forEach(element => {
            element.addEventListener('input', function() {
                validateForm(form); // Validar el formulario cada vez que el valor cambie
            });
            element.addEventListener('blur', function() {
                validateForm(form); // Validar el formulario cuando el campo pierda el foco
            });
            
            // Agregar eventos específicos para select2
            if ($(element).hasClass('select2')) {
                $(element).on('select2:select select2:unselect change', function() {
                    validateForm(form);
                });
            }
        });
        
        // Validar inicialmente
        validateForm(form);
    };





    function showConfirmationDialog(isActive, form) {
        return Swal.fire({
            title: isActive ? '¿Inactivar registro?' : '¿Reactivar registro?',
            html: isActive ?
                '<div class="text-danger mb-3"><i class="fa fa-exclamation-triangle fa-3x"></i></div><p>¡Esta acción no se puede deshacer!</p>' :
                '<div class="text-success mb-3"><i class="fa fa-check-circle fa-3x"></i></div><p>La organización será activada nuevamente.</p>',
            showCancelButton: true,
            confirmButtonColor: isActive ? '#d33' : '#28a745',
            cancelButtonColor: '#3085d6',
            confirmButtonText: isActive ? '<i class="fa fa-trash"></i> Inactivar' : '<i class="fa fa-check"></i> Reactivar',
            cancelButtonText: '<i class="fa fa-times"></i> Cancelar',
            allowOutsideClick: false
        }).then((result) => {
            if (result.value) {
                form.submit();
            }
        });
    }
    
    // Delegación de eventos para el clic en los botones
    document.querySelector('.toggle-status-form').addEventListener('click', function(e) {
        let button = e.target.closest('button');
        if (!button) return; // Si no es un botón dentro del formulario, salir
    
        e.preventDefault(); // Impide la acción por defecto
        let form = button.closest('form');
        let isActive = button.getAttribute('data-status') === '1';
    
        // Llamar a la función de confirmación
        showConfirmationDialog(isActive, form);
    });

    // Validación en el envío del formulario
    window.addEventListener('submit', function(e) {
        const form = e.target.closest('form');
        if (form && !validateForm(form)) {
            e.preventDefault();  // Impide que el formulario se envíe si no es válido
            e.stopPropagation();  // Evita que otros eventos sean disparados
            form.classList.add('was-validated');  // Agregar clases de validación
        }
    });

    // Validación en el envío del formulario (esto es crucial para evitar el envío si no es válido)
    window.addEventListener('submit', function(e) {
        const form = e.target.closest('form');
        if (form && !form.checkValidity()) {
            e.preventDefault();  // Impide que el formulario se envíe si no es válido
            e.stopPropagation();  // Evita que otros eventos sean disparados
            form.classList.add('was-validated');  // Agregar clases de validación
        }
    });
    // =====================================================
    // Función: Inicializar tooltips con jQuery
    // =====================================================
    function initTooltips() {
        $('body').tooltip({
            selector: '[data-toggle="tooltip"],.label',
            boundary: 'window'
        });
    }
    // =====================================================
    // Función: Inicializar DataTables
    // =====================================================
    function initDataTables() {
        $.extend(true, $.fn.dataTable.defaults, {
            columnDefs: [{
                orderable: false,
                searchable: false,
                className: "text-center",
                targets: -1
            }],
            dom: '<"row" <"col-md-4" B> <"col-md-4 d-flex justify-content-start" l> <"col-md-4 d-flex justify-content-end" f> >' +
                '<"row" <"col-12" tr> >' +
                '<"row" <"col-md-6 d-flex justify-content-start" i> <"col-md-6 d-flex justify-content-end" p> >',
            buttons: {
                buttons: [
                    { extend: 'excel', className: 'bg-success btn-sm label', text: '<i class="far fa-file-excel bg-success"></i>', titleAttr: 'Exportar a Excel' },
                    { extend: 'copy', className: 'bg-secondary btn-sm label', text: '<i class="far fa-copy"></i>', titleAttr: 'Copiar a memoria' },
                    { extend: 'csv', className: 'bg-info btn-sm label', text: '<i class="fas fa-file-csv bg-primary"></i>', titleAttr: 'Exportar a CSV' },
                    { extend: 'pdf', className: 'bg-red btn-sm label', text: '<i class="far fa-file-pdf bg-danger"></i>', titleAttr: 'Exportar a PDF' },
                    { extend: 'print', className: 'bg-primary btn-sm label', text: '<i class="fas fa-print"></i>', titleAttr: 'Imprimir' }
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
            initComplete: function() {
                $('.pagination').addClass('pagination-sm');
            },
            drawCallback: function() {
                $('.paginate_button').removeClass('btn-primary').addClass('btn-default');
            }
        });
        $('.datatable').DataTable();
    }
    // =====================================================
    // Función: Configurar manejo de cierre de sesión
    // =====================================================
    function initLogoutHandler() {
        var logoutButton = document.getElementById('logoutButton');
        var logoutForm = document.getElementById('logout-form');
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
                }).then(function(result) {
                    if (result.isConfirmed) {
                        logoutForm.submit();
                    }
                });
            });
        }
    }
    // =====================================================
    // Función: Configurar aviso de expiración de sesión
    // =====================================================
    function initSessionTimeout() {
        var SESSION_LIFETIME = window.sessionData ? window.sessionData.sessionLifetime : 15; // Valor por defecto 30 min
        var WARNING_BEFORE_EXPIRY = 1; // minutos antes de mostrar la alerta
        var warningTime = (SESSION_LIFETIME - WARNING_BEFORE_EXPIRY) * 60 * 1000;

        setTimeout(function() {
            Swal.fire({
                title: 'Sesión a punto de expirar',
                text: 'Tu sesión expirará pronto. ¿Deseas mantenerla activa?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Mantener Sesión',
                cancelButtonText: 'Cerrar Sesión',
                reverseButtons: true
            }).then(function(result) {
                if (result.isConfirmed) {
                    fetch('/keep-alive')
                        .then(function(response) { 
                            if (!response.ok) {
                                throw new Error('La sesión ha expirado.');
                            }
                            return response.json();

                        })
                        .then(function(data) {
                            if (data.status === 'ok') {
                                location.reload();
                            }
                        })
                        .catch(function(error) { 
                            console.error('Error al renovar sesión:', error);
                            Swal.fire({
                                title: 'Error',
                                text: 'Tu sesión ha expirado. Por favor, inicia sesión nuevamente.',
                                icon: 'error',
                                confirmButtonText: 'Aceptar',
                                willClose: () => {
                                    // Redirigir al login después de la alerta o recargar la página
                                    window.location.href = '/login';  // Aquí rediriges al login
                                }
                            }).then((result) => {
                                // Si el usuario da clic en "Aceptar", se redirige al login
                                if (result.isConfirmed) {
                                    window.location.href = '/login'; // Redirige al login
                                } else {
                                    window.location.href = '/login'; // Si hay otra acción, redirige al login
                                }
                            });
                        });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    logoutViaPost();
                }
            });
        }, warningTime);
    }
    // =====================================================
    // Función: Cerrar sesión vía POST
    // =====================================================
    function logoutViaPost() {
        var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch('/logout', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json'
            }
        })
        .then(function(response) {
            if (response.redirected) {
                window.location.href = response.url;
            } else {
                window.location.reload();
            }
        })
        .catch(function(error) {
            console.error('Error al cerrar sesión:', error);
            Swal.fire('Error', 'No se pudo cerrar sesión.', 'error');
        });
    }
    // =====================================================
    // Inicialización: Ejecutar cuando el DOM esté listo
    // =====================================================
    document.addEventListener('DOMContentLoaded', function() {
        initToastr();
        showFlashMessages();
        initTooltips();
        initDataTables();
        initLogoutHandler();
        initSessionTimeout();
    });

    console.log("init.js cargado correctamente");
})();
