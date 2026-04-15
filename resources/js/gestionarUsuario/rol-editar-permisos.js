// resources/js/modals/rol-editar-permisos.js

$(document).ready(function () {

    function mostrarMensaje(tipo, mensaje) {
        $('.toast-notification').remove();

        const toast = $(`
        <div class="toast-notification toast-${tipo}">
            <span>${mensaje}</span>
        </div>
    `);
        $('body').append(toast);
        setTimeout(() => toast.fadeOut(300, function () { $(this).remove(); }), 3000);
    }

    // ========== SELECCIONAR/DESELECCIONAR TODOS ==========
    $(document).on('click', '#selectAllPermisosEdit', function () {
        const todosCheckbox = $('.permiso-checkbox');
        const todosSeleccionados = todosCheckbox.filter(':checked').length === todosCheckbox.length;

        // Si todos están seleccionados, los deselecciona; si no, los selecciona todos
        todosCheckbox.prop('checked', !todosSeleccionados);

        // Cambiar el texto y estilo del botón
        if (!todosSeleccionados) {
            $(this).html('<i class="fas fa-times"></i> Deseleccionar todos');
            $(this).removeClass('btn-secondary').addClass('btn-warning');
        } else {
            $(this).html('<i class="fas fa-check-double"></i> Seleccionar todos');
            $(this).removeClass('btn-warning').addClass('btn-secondary');
        }
    });

    // Botón "Deseleccionar todos" (ahora puede ser redundante, pero lo dejamos)
    $(document).on('click', '#deselectAllPermisosEdit', function () {
        $('.permiso-checkbox').prop('checked', false);
        // También actualizar el botón "Seleccionar todos"
        const selectBtn = $('#selectAllPermisosEdit');
        selectBtn.html('<i class="fas fa-check-double"></i> Seleccionar todos');
        selectBtn.removeClass('btn-warning').addClass('btn-secondary');
    });

    // ========== Cargar datos del rol ==========
    $(document).on('click', '.editar-permisos-rol', function () {
        const id = $(this).data('id');

        $.ajax({
            url: '/admin/roles/' + id + '/permisos',
            type: 'GET',
            success: function (data) {
                $('#edit_rol_id').val(data.rol.idRol);
                $('#edit_rol_nombre').val(data.rol.nombre);
                $('#edit_rol_descripcion').val(data.rol.descripcion);

                $('.permiso-checkbox').each(function () {
                    const permisoId = $(this).val();
                    if (data.permisos_asignados.includes(parseInt(permisoId))) {
                        $(this).prop('checked', true);
                    } else {
                        $(this).prop('checked', false);
                    }
                });

                // Restablecer el botón "Seleccionar todos" a su estado original
                const selectBtn = $('#selectAllPermisosEdit');
                selectBtn.html('<i class="fas fa-check-double"></i> Seleccionar todos');
                selectBtn.removeClass('btn-warning').addClass('btn-secondary');

                $('#modalEditarPermisosRol').modal('show');
            },
            error: function () {
                mostrarMensaje('danger', 'Error al cargar los datos del rol');
            }
        });
    });

    // ========== Guardar cambios ==========
    $('#formEditarPermisosRol').on('submit', function (e) {
        e.preventDefault();
        const id = $('#edit_rol_id').val();

        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...').prop('disabled', true);

        $.ajax({
            url: '/admin/roles/' + id,
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarMensaje('success', response.message);
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarMensaje('danger', response.message || 'Error al actualizar');
                    submitBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function (xhr) {
                let errorMsg = 'Error al actualizar rol';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                mostrarMensaje('danger', errorMsg);
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });
});