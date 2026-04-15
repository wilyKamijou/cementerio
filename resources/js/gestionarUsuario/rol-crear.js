// resources/js/modals/rol-crear.js

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

    // ========== ABRIR MODAL ==========
    $('#btnCrearRol').click(function () {
        $('#modalCrearRol').modal('show');
    });

    // ========== SELECCIONAR/DESELECCIONAR TODOS LOS PERMISOS ==========
    $(document).on('click', '#selectAllPermisosRol', function () {
        const todosCheckbox = $('.permiso-checkbox');
        const todosSeleccionados = todosCheckbox.filter(':checked').length === todosCheckbox.length;

        todosCheckbox.prop('checked', !todosSeleccionados);

        // Cambiar el texto del botón
        if (!todosSeleccionados) {
            $(this).html('<i class="fas fa-times"></i> Deseleccionar todos');
            $(this).removeClass('btn-secondary').addClass('btn-warning');
        } else {
            $(this).html('<i class="fas fa-check-double"></i> Seleccionar todos');
            $(this).removeClass('btn-warning').addClass('btn-secondary');
        }
    });

    // ========== ENVIAR FORMULARIO ==========
    $('#formCrearRol').submit(function (e) {
        e.preventDefault();

        const nombre = $('input[name="nombre"]').val().trim();

        if (!nombre) {
            mostrarToast('El nombre del rol es requerido', 'danger');
            $('input[name="nombre"]').focus();
            return;
        }

        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...').prop('disabled', true);

        $.ajax({
            url: '/admin/roles',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarToast('Rol creado exitosamente', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarToast(response.message || 'Error al crear rol', 'danger');
                    submitBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function (xhr) {
                let errorMsg = 'Error al crear rol';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                mostrarToast(errorMsg, 'danger');
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // ========== LIMPIAR FORMULARIO AL CERRAR ==========
    $('#modalCrearRol').on('hidden.bs.modal', function () {
        $('#formCrearRol')[0].reset();

        // Restablecer el botón "Seleccionar todos"
        const selectBtn = $('#selectAllPermisosRol');
        selectBtn.html('<i class="fas fa-check-double"></i> Seleccionar todos');
        selectBtn.removeClass('btn-warning').addClass('btn-secondary');
    });
});