// resources/js/modules/espacios-editar.js
$(document).ready(function () {
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
    // Cargar datos al abrir modal
    $(document).on('click', '.editar-espacio', function () {
        const id = $(this).data('id');
        $.ajax({
            url: '/admin/espacios/' + id,
            type: 'GET',
            success: function (data) {
                $('#edit_espacio_id').val(data.idEspacio);
                $('#edit_precio').val(data.precio);
                $('#edit_estado').val(data.estado);
                $('#edit_idDir').val(data.idDir);
                $('#edit_idDim').val(data.idDim);
                $('#edit_idCem').val(data.idCem);
                $('#modalEditarEspacio').modal('show');
            },
            error: function () {
                mostrarToast('Error al cargar los datos del espacio', 'danger');
            }
        });
    });

    // Enviar formulario de edición
    $('#formEditarEspacio').on('submit', function (e) {
        e.preventDefault();
        const id = $('#edit_espacio_id').val();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...').prop('disabled', true);

        $.ajax({
            url: '/admin/espacios/' + id,
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarToast('Espacio actualizado exitosamente', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarToast(response.message || 'Error al actualizar', 'danger');
                    submitBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function () {
                mostrarToast('Error al actualizar espacio', 'danger');
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });
});