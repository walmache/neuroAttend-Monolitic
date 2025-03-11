<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('userForm');
        const submitBtn = document.getElementById('submitBtn');

        form.querySelectorAll('input, textarea, select').forEach(element => {
            element.addEventListener('input', checkFormValidity);
            element.addEventListener('blur', checkFormValidity);
        });

        function checkFormValidity() {
            let isValid = true;
            form.querySelectorAll('input, textarea, select').forEach(element => {
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

        $('.select2').select2({
            theme: 'classic',
            width: '100%',
            placeholder: 'Seleccione una opción'
        });

        bsCustomFileInput.init();

    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Agregar evento a todos los botones con clase toggle-password
    document.querySelectorAll('.toggle-password').forEach(function(button) {
        button.addEventListener('click', function() {
            // Obtener el ID del campo de contraseña desde el atributo data-target
            const targetId = this.getAttribute('data-target');
            const passwordInput = document.getElementById(targetId);

            // Cambiar el tipo de input
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.querySelector('i').classList.remove('fa-eye');
                this.querySelector('i').classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                this.querySelector('i').classList.remove('fa-eye-slash');
                this.querySelector('i').classList.add('fa-eye');
            }
        });
    });
});
</script>