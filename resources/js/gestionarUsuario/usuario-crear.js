// resources/js/modals/usuario-crear.js

$(document).ready(function () {

    // ========== ABRIR MODAL ==========
    $('#btnCrearUsuario').on('click', function (e) {
        e.preventDefault();
        $('#modalCrearUsuario').modal('show');
    });

    // ========== PREPARAR NUEVO ROL ==========
    $(document).on('click', '#btnPrepararNuevoRol', function (e) {
        e.preventDefault();
        const nombreRol = $('#nuevoRolNombre').val().trim();
        if (nombreRol) {
            $('#nuevoRolPermisos').slideDown(300);
            $(this).text('Rol "' + nombreRol + '" listo');
            $(this).prop('disabled', true);
            $(this).removeClass('btn-outline-success').addClass('btn-success');
        } else {
            mostrarToast('⚠️ Ingresa un nombre para el rol', 'warning');
            $('#nuevoRolNombre').focus();
        }
    });

    // ========== SELECCIONAR TODOS LOS PERMISOS ==========
    $(document).on('click', '#selectAllNuevosPermisos', function (e) {
        e.preventDefault();
        const todosCheckbox = $('.nuevo-permiso-checkbox');
        const todosSeleccionados = todosCheckbox.filter(':checked').length === todosCheckbox.length;
        todosCheckbox.prop('checked', !todosSeleccionados);
        $(this).text(todosSeleccionados ? 'Seleccionar todos' : 'Deseleccionar todos');
    });

    // ========== ENVIAR FORMULARIO ==========
    $('#formCrearUsuario').on('submit', function (e) {
        e.preventDefault();

        const nombre = $('input[name="name"]').val().trim();
        const email = $('input[name="email"]').val().trim();
        const password = $('input[name="password"]').val();
        const passwordConfirm = $('input[name="password_confirmation"]').val();

        if (!nombre) {
            mostrarToast('❌ El nombre completo es requerido', 'danger');
            $('input[name="name"]').focus();
            return;
        }

        if (!email) {
            mostrarToast('❌ El email es requerido', 'danger');
            $('input[name="email"]').focus();
            return;
        }

        if (!password) {
            mostrarToast('❌ La contraseña es requerida', 'danger');
            $('input[name="password"]').focus();
            return;
        }

        if (password !== passwordConfirm) {
            mostrarToast('❌ Las contraseñas no coinciden', 'danger');
            $('input[name="password"]').focus();
            return;
        }

        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.text();
        submitBtn.text('Guardando...').prop('disabled', true);

        $.ajax({
            url: '/admin/gestionarUsuarios',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarToast('✅ ' + response.message, 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarToast('❌ ' + response.message, 'danger');
                    submitBtn.text(originalText).prop('disabled', false);
                }
            },
            error: function (xhr) {
                let errorMsg = '❌ Error al crear usuario';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = '❌ ' + xhr.responseJSON.message;
                }
                mostrarToast(errorMsg, 'danger');
                submitBtn.text(originalText).prop('disabled', false);
            }
        });
    });

    // ========== LIMPIAR FORMULARIO AL CERRAR ==========
    $('#modalCrearUsuario').on('hidden.bs.modal', function () {
        $('#formCrearUsuario')[0].reset();
        $('#nuevoRolPermisos').hide();
        $('#btnPrepararNuevoRol').text('Preparar').prop('disabled', false).removeClass('btn-success').addClass('btn-outline-success');
        $('#nuevoRolNombre').val('');
    });

    // ========== FUNCIÓN PARA MOSTRAR TOAST (esquina derecha) ==========
    function mostrarToast(mensaje, tipo) {
        const toast = $(`
            <div class="toast-notification toast-${tipo}">
                <i class="fas ${tipo === 'success' ? 'fa-check-circle' : tipo === 'danger' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
                <span>${mensaje}</span>
            </div>
        `);
        $('body').append(toast);
        setTimeout(() => {
            toast.fadeOut(300, function () { $(this).remove(); });
        }, 3000);
    }
});