// resources/js/modules/toast.js
//import toastr from 'toastr';

/**
 * Configurar opciones globales del toastr
 */
export function setupToastr() {
    toastr.options.closeButton = true;
    toastr.options.timeOut = 5000;
    toastr.options.extendedTimeOut = 0;
    toastr.options.closeHtml = '<button><i class="fa fa-times-circle"></i></button>';
}

/**
 * Mostrar un mensaje toast
 * @param {string} type - Tipo de mensaje (success, error, warning, info)
 * @param {string} message - Contenido del mensaje
 */

export function showToast(type, message) {
    if (type === 'success') toastr.success(message);
    if (type === 'error') toastr.error(message);
    if (type === 'warning') toastr.warning(message);
    if (type === 'info') toastr.info(message);
}

// Ejecutar automáticamente si hay mensajes de sesión
document.addEventListener("DOMContentLoaded", function () {
    if (window.flashMessages) {
        Object.keys(window.flashMessages).forEach(type => {
            showToast(type, window.flashMessages[type]);
        });
    }
});
/**
 * Inicializar sistema de notificaciones y mostrar mensajes flash
 */
export function initializeToasts() {
    setupToastr();
    
    // Mostrar mensajes flash de la sesión
    if (window.flashMessages) {
        Object.entries(window.flashMessages).forEach(([type, messages]) => {
            if (Array.isArray(messages)) {
                messages.forEach(message => showToast(type, message));
            } else {
                showToast(type, messages);
            }
        });
    }
}

export default {
    setup: setupToastr,
    show: showToast,
    initialize: initializeToasts
};
