// resources/js/modules/direcciones-editar.js
$(document).ready(function () {
    // ========== FUNCIÓN PARA MOSTRAR TOAST ==========
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

    // ========== VISTA PREVIA DE DIRECCIÓN ==========
    function actualizarPreviewEditar() {
        var seccion = $('#edit_seccion').val();
        var numero = $('#edit_numero').val();
        var calle = $('#edit_calle').val();
        var fila = $('#edit_fila').val();

        if (seccion && numero && calle && fila) {
            var direccionCompleta = `Sección ${seccion} - N° ${numero}, Calle ${calle}, Fila ${fila}`;
            $('#previewTextoEditar').text(direccionCompleta);
            $('#previewDireccionEditar').fadeIn(200);
        } else {
            $('#previewDireccionEditar').fadeOut(200);
        }
    }

    // ========== CARGAR DATOS AL ABRIR MODAL ==========
    $(document).on('click', '.editar-direccion', function () {
        const id = $(this).data('id');
        $.ajax({
            url: '/admin/direcciones/' + id,
            type: 'GET',
            success: function (data) {
                $('#edit_direccion_id').val(data.idDir);
                $('#edit_seccion').val(data.seccion);
                $('#edit_numero').val(data.numero);
                $('#edit_calle').val(data.calle);
                $('#edit_fila').val(data.fila);

                // Forzar actualización de la vista previa después de cargar datos
                setTimeout(function () {
                    actualizarPreviewEditar();
                }, 100);

                $('#modalEditarDireccion').modal('show');
            },
            error: function () {
                mostrarToast('Error al cargar los datos de la dirección', 'danger');
            }
        });
    });

    // ========== ENVIAR FORMULARIO DE EDICIÓN ==========
    $('#formEditarDireccion').on('submit', function (e) {
        e.preventDefault();
        const id = $('#edit_direccion_id').val();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...').prop('disabled', true);

        $.ajax({
            url: '/admin/direcciones/' + id,
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarToast('Dirección actualizada exitosamente', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarToast(response.message || 'Error al actualizar', 'danger');
                    submitBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function () {
                mostrarToast('Error al actualizar dirección', 'danger');
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // ========== EVENTOS PARA VISTA PREVIA EN TIEMPO REAL ==========
    $('#edit_seccion, #edit_numero, #edit_calle, #edit_fila').on('input', function () {
        actualizarPreviewEditar();
    });

    // ========== RECALCULAR CUANDO EL MODAL SE ABRE ==========
    $('#modalEditarDireccion').on('shown.bs.modal', function () {
        actualizarPreviewEditar();
    });
});