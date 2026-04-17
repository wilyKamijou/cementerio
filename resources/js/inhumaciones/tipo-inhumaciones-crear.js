// resources/js/modules/tipo-inhumaciones.js
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

    // ========== CREAR TIPO INHUMACIÓN ==========
    $('#btnCrearTipoInhumacion').click(function () {
        $('#modalCrearTipoInhumacion').modal('show');
    });

    $('#formCrearTipoInhumacion').submit(function (e) {
        e.preventDefault();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...').prop('disabled', true);

        $.ajax({
            url: '/admin/tipo_inhumaciones',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarToast('Tipo de inhumación creado exitosamente', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarToast(response.message || 'Error al crear', 'danger');
                    submitBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function (xhr) {
                let mensaje = 'Error al crear tipo de inhumación';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    mensaje = xhr.responseJSON.message;
                }
                mostrarToast(mensaje, 'danger');
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // ========== EDITAR TIPO INHUMACIÓN ==========
    $(document).on('click', '.editar-tipo-inhumacion', function () {
        const id = $(this).data('id');
        $.ajax({
            url: '/admin/tipo_inhumaciones/' + id,
            type: 'GET',
            success: function (data) {
                $('#edit_tipo_id').val(data.idTipo);
                $('#edit_nombre_tipo').val(data.nombre);
                $('#edit_precio_tipo').val(data.precio);
                $('#edit_capacidad_tipo').val(data.capacidadMax);
                $('#edit_area_tipo').val(data.areaBase);
                $('#edit_estado_tipo').val(data.estado);
                $('#modalEditarTipoInhumacion').modal('show');
            },
            error: function () {
                mostrarToast('Error al cargar los datos', 'danger');
            }
        });
    });

    // ========== ENVIAR EDICIÓN ==========
    $('#formEditarTipoInhumacion').submit(function (e) {
        e.preventDefault();
        const id = $('#edit_tipo_id').val();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Actualizando...').prop('disabled', true);

        $.ajax({
            url: '/admin/tipo_inhumaciones/' + id,
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarToast('Tipo de inhumación actualizado exitosamente', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarToast(response.message || 'Error al actualizar', 'danger');
                    submitBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function (xhr) {
                let mensaje = 'Error al actualizar';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    mensaje = xhr.responseJSON.message;
                }
                mostrarToast(mensaje, 'danger');
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // ========== ELIMINAR TIPO INHUMACIÓN ==========
    $(document).on('click', '.eliminar-tipo-inhumacion', function () {
        const id = $(this).data('id');
        if (confirm('¿Estás seguro de eliminar este tipo de inhumación?')) {
            $.ajax({
                url: '/admin/tipo_inhumaciones/' + id,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        mostrarToast('Tipo de inhumación eliminado exitosamente', 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        mostrarToast(response.message || 'Error al eliminar', 'danger');
                    }
                },
                error: function (xhr) {
                    let mensaje = 'Error al eliminar';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        mensaje = xhr.responseJSON.message;
                    }
                    mostrarToast(mensaje, 'danger');
                }
            });
        }
    });

    // ========== BUSCADOR ==========
    $('#buscarTipoInhumacion').on('keyup', function () {
        var value = $(this).val().toLowerCase();
        $('.fila-tipo-inhumacion').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});