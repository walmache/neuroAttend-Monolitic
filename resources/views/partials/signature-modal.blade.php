<!-- signature-modal.blade.php -->
<div class="modal fade" id="signatureModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="signatureModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" style="max-width: 90%; height: 90vh; margin: auto;">
        <div class="modal-content" style="height: 100%; display: flex; flex-direction: column;">
            <!-- Cabecera con Información del Usuario y Reunión -->
            <div class="modal-header bg-primary text-white d-flex justify-content-center">
                <h6 class="modal-title" id="signatureModalLabel" style="white-space: nowrap;">
                    Participante: <span id="modalUserName" class="font-weight-bold"></span> | 
                    Reunión: ggg <span id="modalMeetingName" class="font-weight-bold"></span>
                </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4" style="flex: 1; display: flex; flex-direction: column; justify-content: flex-start; overflow: hidden;">
                <!-- Canvas para la Firma -->
                <canvas id="signatureCanvas" class= "border border-primary"></canvas>
            </div>

            <div class="modal-footer" style="flex-shrink: 0; display: flex; justify-content: space-between; width: 100%;">
                <button type="button" id="clearSignature" class="btn btn-warning">Borrar Firma</button>
                <button type="button" id="cancelSignature" class="btn btn-secondary">Cancelar</button>
                <button type="button" id="saveSignature" class="btn btn-primary" >Aceptar</button>
            </div>
        </div>
    </div>
</div>