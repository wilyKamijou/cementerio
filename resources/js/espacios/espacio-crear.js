// resources/js/modals/espacio-crear.js

$(document).ready(function () {
    // ========== FUNCIÓN PARA MOSTRAR TOAST ==========
    function mostrarToast(mensaje, tipo) {
        $('.toast-notification').remove();

        const icono = tipo === 'success' ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-exclamation-circle"></i>';
        const toast = $(`
            <div class="toast-notification toast-${tipo}">
                ${icono}
                <span>${mensaje}</span>
            </div>
        `);
        $('body').append(toast);
        setTimeout(() => {
            toast.fadeOut(300, function () { $(this).remove(); });
        }, 3000);
    }

    // ========== ABRIR MODAL ==========
    $('#btnCrearEspacio').click(function () {
        $('#modalCrearEspacio').modal('show');
    });

    // ========== ENVIAR FORMULARIO ==========
    $('#formCrearEspacio').submit(function (e) {
        e.preventDefault();

        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...').prop('disabled', true);

        $.ajax({
            url: '/admin/espacios',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarToast('Espacio creado exitosamente', 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    mostrarToast(response.message || 'Error al crear espacio', 'danger');
                    submitBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function (xhr) {
                let mensaje = 'Error al crear espacio';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    mensaje = xhr.responseJSON.message;
                }
                mostrarToast(mensaje, 'danger');
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });
});