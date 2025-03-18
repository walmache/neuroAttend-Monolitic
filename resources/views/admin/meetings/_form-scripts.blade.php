<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('meeting');
        if (form) {
            validateFormRealTime(form);
        }

        // Inicializar Select2
        $('.select2').select2({
            theme: 'classic',
            width: '100%',
            placeholder: 'Seleccione una opción'
        });

        // Inicializar DateRangePicker 
        const originalDateTime = $('#datetime').val();        
        $('.datetimepicker').daterangepicker({
            timePicker: true,
            singleDatePicker: true,
            showDropdowns: true,
            timePicker24Hour: true,
            timePickerIncrement: 15,
            minDate: moment().startOf('day'),
            startDate: originalDateTime ? moment(originalDateTime) : function() {
                var now = moment();
                var minutes = now.minutes();
                var remainder = minutes % 10;
                if (remainder > 0) {
                    now.add(10 - remainder, 'minutes');
                }
                now.seconds(0);
                return now;
            }(),
            locale: {
                format: 'YYYY-MM-DD HH:mm',
                applyLabel: 'Aplicar',
                cancelLabel: 'Cancelar',
                fromLabel: 'Desde',
                toLabel: 'Hasta',
                customRangeLabel: 'Personalizado',
                daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
            }
        });
    });

    $(document).ready(function() {
        function updateLocationLabel() {
            var isChecked = $('#is_virtual').prop('checked');
            $('label[for="location"]').text(isChecked ? 'Enlace:' : 'Ubicación:');
        }
        updateLocationLabel();
        $('#is_virtual').on('change', function() {
            updateLocationLabel();
        });
    });



</script>