// resources/js/modules/mantenimientos.js
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

    // ========== CREAR MANTENIMIENTO ==========
    $('#btnCrearMantenimiento').click(function () {
        $('#modalCrearMantenimiento').modal('show');
    });

    $('#formCrearMantenimiento').submit(function (e) {
        e.preventDefault();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...').prop('disabled', true);

        $.ajax({
            url: '/admin/mantenimientos',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarToast('Mantenimiento registrado exitosamente', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarToast(response.message || 'Error al registrar', 'danger');
                    submitBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function (xhr) {
                let mensaje = 'Error al registrar mantenimiento';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    mensaje = xhr.responseJSON.message;
                }
                mostrarToast(mensaje, 'danger');
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // ========== EDITAR MANTENIMIENTO ==========
    $(document).on('click', '.editar-mantenimiento', function () {
        const id = $(this).data('id');
        $.ajax({
            url: '/admin/mantenimientos/' + id,
            type: 'GET',
            success: function (data) {
                $('#edit_mantenimiento_id').val(data.idMant);
                $('#edit_idEspacio').val(data.idEspacio);
                $('#edit_tipo_mantenimiento').val(data.tipo);
                $('#edit_fechaMant').val(data.fechaMant);
                $('#edit_precio_mantenimiento').val(data.precio);
                $('#edit_estado_mantenimiento').val(data.estado);
                $('#edit_descripcion_mantenimiento').val(data.descripcion);
                $('#modalEditarMantenimiento').modal('show');
            },
            error: function (xhr) {
                let mensaje = 'Error al cargar los datos del mantenimiento';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    mensaje = xhr.responseJSON.message;
                }
                mostrarToast(mensaje, 'danger');
            }
        });
    });

    // ========== ENVIAR EDICIÓN DE MANTENIMIENTO ==========
    $('#formEditarMantenimiento').submit(function (e) {
        e.preventDefault();
        const id = $('#edit_mantenimiento_id').val();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Actualizando...').prop('disabled', true);

        $.ajax({
            url: '/admin/mantenimientos/' + id,
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarToast('Mantenimiento actualizado exitosamente', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarToast(response.message || 'Error al actualizar', 'danger');
                    submitBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function (xhr) {
                let mensaje = 'Error al actualizar mantenimiento';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    mensaje = xhr.responseJSON.message;
                }
                mostrarToast(mensaje, 'danger');
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // ========== ELIMINAR MANTENIMIENTO ==========
    $(document).on('click', '.eliminar-mantenimiento', function () {
        const id = $(this).data('id');
        if (confirm('¿Estás seguro de eliminar este mantenimiento? Esta acción no se puede deshacer.')) {
            $.ajax({
                url: '/admin/mantenimientos/' + id,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        mostrarToast('Mantenimiento eliminado exitosamente', 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        mostrarToast(response.message || 'Error al eliminar', 'danger');
                    }
                },
                error: function (xhr) {
                    let mensaje = 'Error al eliminar mantenimiento';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        mensaje = xhr.responseJSON.message;
                    }
                    mostrarToast(mensaje, 'danger');
                }
            });
        }
    });

    // ========== BUSCADOR PARA MANTENIMIENTOS ==========
    $('#buscarMantenimiento').on('keyup', function () {
        var value = $(this).val().toLowerCase();
        $('.fila-mantenimiento').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // ========== VALIDACIÓN DE FECHAS ==========
    $('#formCrearMantenimiento input[name="fechaMant"]').on('change', function () {
        var fechaSeleccionada = new Date($(this).val());
        var fechaActual = new Date();
        fechaActual.setHours(0, 0, 0, 0);

        if (fechaSeleccionada < fechaActual) {
            mostrarToast('La fecha de mantenimiento no puede ser anterior a hoy', 'danger');
            $(this).val('');
        }
    });

    $('#formEditarMantenimiento input[name="fechaMant"]').on('change', function () {
        var fechaSeleccionada = new Date($(this).val());
        var fechaActual = new Date();
        fechaActual.setHours(0, 0, 0, 0);

        if (fechaSeleccionada < fechaActual) {
            mostrarToast('La fecha de mantenimiento no puede ser anterior a hoy', 'danger');
            $(this).val('');
        }
    });

    // ========== ACTUALIZAR ESPACIOS DISPONIBLES (opcional) ==========
    function actualizarEspaciosDisponibles() {
        $.ajax({
            url: '/admin/espacios/disponibles',
            type: 'GET',
            success: function (espacios) {
                var select = $('#formCrearMantenimiento select[name="idEspacio"]');
                select.empty();
                select.append('<option value="">-- Seleccionar espacio --</option>');
                $.each(espacios, function (key, espacio) {
                    select.append('<option value="' + espacio.idEspacio + '">' +
                        'Espacio #' + espacio.idEspacio + ' - ' +
                        (espacio.direccion ? espacio.direccion.calle : 'Sin dirección') +
                        '</option>');
                });
            }
        });
    }
});