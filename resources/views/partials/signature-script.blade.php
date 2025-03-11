<script>
document.addEventListener("DOMContentLoaded", function () {
    let signaturePad;
    let activeCheckbox = null;
    let saveButton; // Declaramos el botón de "Guardar"
    let bandera = 1;

    // Evento al hacer click en un checkbox de marcar asistencia
    document.querySelectorAll(".mark-attendance").forEach(checkbox => {
        checkbox.addEventListener("click", function () {
            if (this.checked) {
                // Guardar referencia al checkbox activo
                activeCheckbox = this;

                // Obtener datos del usuario y reunión desde atributos `data-`
                document.getElementById("modalUserName").textContent = activeCheckbox.dataset.userName;
                document.getElementById("modalMeetingName").textContent = activeCheckbox.dataset.meetingName;

                // Mostrar modal
                $("#signatureModal").modal("show");

                // Asegurarse de que el modal está completamente visible antes de inicializar el SignaturePad
                $("#signatureModal").on('shown.bs.modal', function () {
                    // Ajustar el tamaño del canvas
                    let canvas = document.getElementById("signatureCanvas");
                    let parent = canvas.parentElement;

                    // Ajustar el ancho al 100% del contenedor
                    canvas.width = parent.clientWidth;

                    // Ajustar la altura al 95% del contenedor
                    canvas.height = parent.clientHeight * 0.95;  // 95% del espacio disponible

                    // Inicializar SignaturePad solo si no está ya inicializado
                    if (!signaturePad) {
                        signaturePad = new SignaturePad(canvas, {
                            penColor: "rgb(0, 0, 0)",
                            backgroundColor: "rgb(255, 255, 255)"
                        });
                    } else {
                        signaturePad.clear(); // Limpiar la firma previa
                    }
                });

                // Establecer el botón de "Guardar"
                saveButton = document.getElementById("saveSignature");
                saveButton.addEventListener("click", function () {
                    if (!signaturePad || signaturePad.isEmpty()) {
                        alert("Por favor, firme antes de guardar.");
                        return;
                    }

                    const userId = activeCheckbox.dataset.userId;
                    const meetingId = activeCheckbox.dataset.meetingId;
                    const signatureData = signaturePad.toDataURL("image/png");

                    // Deshabilitar el botón y mostrar mensaje de carga
                    saveButton.disabled = true;
                    saveButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Guardando...';

                    fetch(`{{ route('admin.meetings.attendances.store', [':meeting_id', ':user_id']) }}`
                        .replace(':meeting_id', meetingId).replace(':user_id', userId), {
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
                    .then(async response => {
                        if (!response.ok) throw new Error(await response.text());
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            const checkbox = document.querySelector(`.mark-attendance[data-user-id="${userId}"]`);
                            if (checkbox) {
                                // Deshabilitar el checkbox y marcarlo como seleccionado
                                checkbox.disabled = true;
                                checkbox.checked = true; // Marcar el checkbox como seleccionado
                                bandera = 0;
                            }
                            $("#signatureModal").modal("hide");
                        } else {
                            throw new Error(data.message || "Error al guardar");
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Error: " + error.message);
                    })
                    .finally(() => {
                        // Habilitar el botón y restaurar el texto
                        saveButton.disabled = false;
                        saveButton.innerHTML = 'Aceptar';
                    });
                });

                // Evento para cancelar (cerrar y desmarcar checkbox)
                document.getElementById("cancelSignature").onclick = function () {
                    activeCheckbox.checked = false; // Desmarcar el checkbox
                    $("#signatureModal").modal("hide"); // Cerrar el modal
                };
            }
        });
    });

    // Limpiar firma al hacer click en "Borrar Firma"
    document.getElementById("clearSignature").addEventListener("click", () => signaturePad.clear());

    // Cerrar modal al ocultarlo (se asegura de limpiar y desmarcar)
    $("#signatureModal").on("hidden.bs.modal", function () {
        if (activeCheckbox && bandera) {
            activeCheckbox.checked = false; // Desmarcar el checkbox
        }
        signaturePad.clear(); // Limpiar la firma
    });

});
</script>
