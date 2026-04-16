// resources/js/modules/cementerios-editar.js
$(document).ready(function () {
    // Cargar datos al abrir modal
    $(document).on('click', '.editar-cementerio', function () {
        const id = $(this).data('id');
        $.ajax({
            url: '/admin/cementerios/' + id,
            type: 'GET',
            success: function (data) {
                $('#edit_cementerio_id').val(data.idCem);
                $('#edit_nombre_cementerio').val(data.nombre);
                $('#edit_estado_cementerio').val(data.estado);
                $('#edit_localizacion').val(data.localizacion || '');
                $('#edit_espacioDisp').val(data.espacioDisp || '');
                $('#modalEditarCementerio').modal('show');
            },
            error: function () {
                mostrarToast('Error al cargar los datos del cementerio', 'danger');
            }
        });
    });

    // Enviar formulario de edición
    $('#formEditarCementerio').on('submit', function (e) {
        e.preventDefault();
        const id = $('#edit_cementerio_id').val();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...').prop('disabled', true);

        $.ajax({
            url: '/admin/cementerios/' + id,
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarToast('Cementerio actualizado exitosamente', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarToast(response.message || 'Error al actualizar', 'danger');
                    submitBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function () {
                mostrarToast('Error al actualizar cementerio', 'danger');
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });
    // ========== FUNCIÓN PARA MOSTRAR TOAST (sin iconos) ==========
    function mostrarToast(mensaje, tipo) {
        $('.toast-notification').remove();

        const toast = $(`
        <div class="toast-notification toast-${tipo}">
            <span>${mensaje}</span>
        </div>
    `);
        $('body').append(toast);
        setTimeout(() => {
            toast.fadeOut(300, function () { $(this).remove(); });
        }, 3000);
    }
});