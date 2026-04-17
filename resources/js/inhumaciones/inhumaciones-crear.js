// resources/js/modules/inhumaciones.js

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

    // ========== CAMBIO DE PESTAÑAS ==========
    $('[data-tab]').click(function () {
        var tab = $(this).data('tab');
        $('[data-tab]').removeClass('btn-primary').addClass('btn-outline-primary');
        $(this).removeClass('btn-outline-primary').addClass('btn-primary');
        $('.tab-pane').hide();
        $('#tab-' + tab).show();
    });

    // ========== CREAR INHUMACIÓN ==========
    $('#btnCrearInhumacion').click(function () {
        $('#modalCrearInhumacion').modal('show');
    });

    $('#formCrearInhumacion').submit(function (e) {
        e.preventDefault();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...').prop('disabled', true);

        $.ajax({
            url: '/admin/inhumaciones',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarToast('Inhumación creada exitosamente', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarToast(response.message || 'Error al crear', 'danger');
                    submitBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function (xhr) {
                let mensaje = 'Error al crear inhumación';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    mensaje = xhr.responseJSON.message;
                }
                mostrarToast(mensaje, 'danger');
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // ========== EDITAR INHUMACIÓN ==========
    $(document).on('click', '.editar-inhumacion', function () {
        const id = $(this).data('id');
        $.ajax({
            url: '/admin/inhumaciones/' + id,
            type: 'GET',
            success: function (data) {
                $('#edit_idInhum').val(data.idInhum);
                $('#edit_nombre').val(data.nombre);
                $('#edit_paterno').val(data.paterno);
                $('#edit_materno').val(data.materno || '');
                $('#edit_fechaNaci').val(data.fechaNaci || '');
                $('#edit_fechaDefun').val(data.fechaDefun);
                $('#edit_fechaInhuma').val(data.fechaInhuma);
                $('#edit_causaMuer').val(data.causaMuer || '');
                $('#edit_idEspacio').val(data.idEspacio);
                $('#edit_idTipo').val(data.idTipo);
                $('#modalEditarInhumacion').modal('show');
            },
            error: function () {
                mostrarToast('Error al cargar los datos', 'danger');
            }
        });
    });

    // ========== ENVIAR EDICIÓN ==========
    $('#formEditarInhumacion').submit(function (e) {
        e.preventDefault();
        const id = $('#edit_idInhum').val();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Actualizando...').prop('disabled', true);

        $.ajax({
            url: '/admin/inhumaciones/' + id,
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarToast('Inhumación actualizada exitosamente', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarToast(response.message || 'Error al actualizar', 'danger');
                    submitBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function (xhr) {
                let mensaje = 'Error al actualizar inhumación';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    mensaje = xhr.responseJSON.message;
                }
                mostrarToast(mensaje, 'danger');
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // ========== ELIMINAR INHUMACIÓN ==========
    $(document).on('click', '.eliminar-inhumacion', function () {
        const id = $(this).data('id');
        if (confirm('¿Estás seguro de eliminar esta inhumación? Esta acción liberará el espacio.')) {
            $.ajax({
                url: '/admin/inhumaciones/' + id,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        mostrarToast('Inhumación eliminada exitosamente', 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        mostrarToast(response.message || 'Error al eliminar', 'danger');
                    }
                },
                error: function () {
                    mostrarToast('Error al eliminar inhumación', 'danger');
                }
            });
        }
    });

    // ========== BUSCADOR ==========
    $('#buscarInhumacion').on('keyup', function () {
        var value = $(this).val().toLowerCase();
        $('.fila-inhumacion').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});