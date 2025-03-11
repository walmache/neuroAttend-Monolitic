<script>
document.addEventListener("DOMContentLoaded", function () {
    // Referencias a elementos del DOM
    const modal = new bootstrap.Modal(document.getElementById("signatureModal"));
    const modalElement = document.getElementById("signatureModal");
    const canvas = document.getElementById("signatureCanvas");
    const clearButton = document.getElementById("clearSignature");
    const saveButton = document.getElementById("saveSignature");
    const cancelButton = document.querySelector(".btn-secondary[data-bs-dismiss='modal']");
    const closeButton = document.querySelector(".modal-header .close");
    
    let signaturePad;
    let currentCheckbox = null; // Variable para rastrear el checkbox actual
    
    // Función para inicializar y configurar el SignaturePad
    function initializeSignaturePad() {
        // Configuración adaptativa según la resolución del dispositivo
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        
        // Dimensionar el canvas correctamente
        function resizeCanvas() {
            const modalBody = document.querySelector(".modal-body");
            const width = modalBody.clientWidth * 0.95;
            const height = modalBody.clientHeight * 0.9;
            
            // Establecer dimensiones físicas del canvas
            canvas.width = width * ratio;
            canvas.height = height * ratio;
            
            // Establecer dimensiones de visualización CSS
            canvas.style.width = `${width}px`;
            canvas.style.height = `${height}px`;
            
            // Escalar el contexto del canvas
            const ctx = canvas.getContext("2d");
            ctx.scale(ratio, ratio);
            
            // Si ya existe un signaturePad, hay que recrearlo después de redimensionar
            if (signaturePad) {
                const data = signaturePad.toData();
                signaturePad = new SignaturePad(canvas, {
                    minWidth: 0.5,
                    maxWidth: 2.5,
                    penColor: "blue",
                    throttle: 0,
                    minDistance: 1,
                    velocityFilterWeight: 0.4
                });
                
                // Restaurar los datos si existían
                if (data && data.length) {
                    signaturePad.fromData(data);
                }
            } else {
                // Creación inicial
                signaturePad = new SignaturePad(canvas, {
                    minWidth: 0.5,
                    maxWidth: 2.5,
                    penColor: "blue",
                    throttle: 0,
                    minDistance: 1,
                    velocityFilterWeight: 0.4
                });
            }
        }
        
        // Aplicar tamaño inicial
        resizeCanvas();
        
        // Eventos de redimensionamiento
        window.addEventListener("resize", resizeCanvas);
        
        // Evento especial para cuando el modal se muestra (garantiza dimensiones correctas)
        modalElement.addEventListener('shown.bs.modal', resizeCanvas);
        
        return signaturePad;
    }
    
    // Función para limpiar el pad y desmarcar el checkbox
    function resetFormState() {
        // Limpiar el canvas
        if (signaturePad) {
            signaturePad.clear();
        }
        
        console.log (currentCheckbox)
        // Desmarcar el checkbox actual si existe
        if (currentCheckbox) {
            currentCheckbox.checked = false;
            currentCheckbox = null; // Limpiar la referencia
        }
    }
    
    // Limpiar firma
    clearButton.addEventListener('click', function(event) {
        event.preventDefault();
        if (signaturePad) {
            signaturePad.clear();
        }
    });
    
    // Manejo de checkboxes de asistencia
    document.querySelectorAll(".mark-attendance").forEach(checkbox => {
        checkbox.addEventListener("change", function() {
            if (this.checked) {
                // Guardar referencia al checkbox actual
                currentCheckbox = this;
                console.log (this)
                
                // Obtener datos
                let userId = this.dataset.userId;
                let userName = this.dataset.userName;
                let meetingId = this.dataset.meetingId;
                let meetingName = this.dataset.meetingName;
                
                // Actualizar contenido del modal
                document.getElementById("modalUserName").innerText = userName;
                document.getElementById("modalMeetingName").innerText = meetingName;
                
                // Guardar IDs en los botones
                saveButton.dataset.userId = userId;
                saveButton.dataset.meetingId = meetingId;
                
                // Mostrar modal
                modal.show();
                
                // Asegurar que SignaturePad esté inicializado correctamente
                if (!signaturePad) {
                    signaturePad = initializeSignaturePad();
                } else {
                    signaturePad.clear();
                }
            }
        });
    });
    
    // Guardar firma y registrar asistencia
    saveButton.addEventListener("click", function() {
        // Verificar si hay firma
        if (signaturePad && signaturePad.isEmpty()) {
            alert("Por favor, firme antes de guardar.");
            return;
        }
        
        let userId = this.dataset.userId;
        let meetingId = this.dataset.meetingId;
        let signatureData = signaturePad.toDataURL("image/png");
        
        // Mostrar indicador de carga
        saveButton.disabled = true;
        saveButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';
        
        fetch(`{{ route('admin.meetings.attendances.store', [':meeting_id', ':user_id']) }}`
              .replace(':meeting_id', meetingId)
              .replace(':user_id', userId), {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ 
                user_id: userId, 
                signature: signatureData,
                timestamp: new Date().toISOString()
            })
        })
        .then(res => res.ok ? res.json() : res.text().then(text => { throw new Error(text) }))
        .then(data => {
            if (data.success) {
                // Éxito - no desmarcamos el checkbox aquí ya que queremos que permanezca marcado
                const checkbox = document.querySelector(`.mark-attendance[data-user-id="${userId}"]`);
                if (checkbox) {
                    checkbox.disabled = true;
                    checkbox.checked = true;
                    
                    // Agregar una marca visual al elemento padre (fila de la tabla)
                    const row = checkbox.closest('tr');
                    if (row) {
                        row.classList.add('table-success');
                    }
                }
                
                // Limpiar la referencia al checkbox actual ya que se procesó correctamente
                currentCheckbox = null;
                
                // Limpiar y cerrar
                signaturePad.clear();
                modal.hide();
                
                // Verificamos si SweetAlert está disponible
                if (typeof Swal !== 'undefined') {
                    // Notificación con SweetAlert
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    
                    Toast.fire({
                        icon: 'success',
                        title: 'Asistencia registrada correctamente'
                    });
                } else {
                    // Fallback a alert estándar
                    alert("Asistencia registrada correctamente");
                }
            } else {
                alert("Error: " + (data.message || "Error al guardar la firma"));
                resetFormState(); // Resetear el estado en caso de error
            }
        })
        .catch(error => {
            console.error("Error en la respuesta del servidor:", error);
            alert("Error en el servidor. Revisa la consola para más detalles.");
            resetFormState(); // Resetear el estado en caso de error
        })
        .finally(() => {
            // Restaurar botón
            saveButton.disabled = false;
            saveButton.innerHTML = 'Aceptar';
        });
    });
    
    // Cancelar firma (botón Cancelar)
    cancelButton.addEventListener("click", function() {
        resetFormState();
    });
    
    // Manejar el cierre del modal con botón X
    if (closeButton) {
        closeButton.addEventListener("click", function() {
            resetFormState();
        });
    }
    
    // Manejar cierre del modal con ESC o clic fuera
    modalElement.addEventListener('hidden.bs.modal', function() {
        resetFormState();
    });
    
    // Inicializar el SignaturePad
    signaturePad = initializeSignaturePad();
});
</script>