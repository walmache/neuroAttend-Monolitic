<script>

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('userForm');
        const submitBtn = document.getElementById('submitBtn');

        window.resetForm = function() {
            form.reset();
            form.classList.remove('was-validated');
            form.querySelectorAll('.form-control').forEach(element => {
                element.classList.remove('is-valid', 'is-invalid');
            });
            submitBtn.disabled = true;
            form.querySelectorAll('.invalid-feedback').forEach(element => {
                element.style.display = 'none';
            });

            // Reset Select2
            $('.select2').val(null).trigger('change');

        };

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