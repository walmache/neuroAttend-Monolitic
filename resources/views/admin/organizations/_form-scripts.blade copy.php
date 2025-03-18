<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('organization');
        const submitBtn = document.getElementById('submitBtn');

        window.resetForm = function() {
            window.location.href="{{ route('admin.organizations.index') }}"
            // form.reset();
            // form.classList.remove('was-validated');
            // form.querySelectorAll('.form-control').forEach(element => {
            //     element.classList.remove('is-valid', 'is-invalid');
            // });
            // submitBtn.disabled = true;
            // form.querySelectorAll('.invalid-feedback').forEach(element => {
            //     element.style.display = 'none';
            // });
        };

        form.querySelectorAll('input, textarea').forEach(element => {
            element.addEventListener('input', checkFormValidity);
            element.addEventListener('blur', checkFormValidity);
        });

        function checkFormValidity() {
            let isValid = true;
            form.querySelectorAll('input, textarea').forEach(element => {
                if (!element.checkValidity()) {
                    isValid = false;
                    element.classList.add('is-invalid');
                    element.classList.remove('is-valid');
                } else {
                    element.classList.add('is-valid');
                    element.classList.remove('is-invalid');
                }
            });
            submitBtn.disabled = !isValid;
        }

        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('click', function(e) {
            let button = e.target.closest('.toggle-status-form button');
            if (!button) return; // Si no es un botón dentro del formulario, salir

            e.preventDefault();
            let form = button.closest('form');
            let isActive = button.getAttribute('data-status') === '1';

            Swal.fire({
                title: isActive ? '¿Inactivar organización?' : '¿Reactivar organización?',
                html: isActive ?
                    '<div class="text-danger mb-3"><i class="fa fa-exclamation-triangle fa-3x"></i></div><p>¡Esta acción no se puede deshacer!</p>' : '<div class="text-success mb-3"><i class="fa fa-check-circle fa-3x"></i></div><p>La organización será activada nuevamente.</p>',
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
        });
    });
</script>