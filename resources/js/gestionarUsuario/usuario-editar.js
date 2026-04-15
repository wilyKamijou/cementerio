// resources/js/modals/usuario-editar.js

$(document).ready(function () {

    // ========== MOSTRAR/OCULTAR CONTRASEÑA ==========
    $(document).on('click', '.toggle-password-edit', function () {
        const targetId = $(this).data('target');
        const input = $('#' + targetId);
        const icon = $(this).find('i');

        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // ========== BLOQUEO MUTUO ENTRE EMPLEADO Y CLIENTE ==========
    const editSelectEmpleado = $('#edit_idEmpleado');
    const editSelectCliente = $('#edit_idCliente');

    function bloquearMutuoEdicion() {
        editSelectEmpleado.off('change').on('change', function () {
            if ($(this).val() !== '') {
                editSelectCliente.prop('disabled', true);
                editSelectCliente.val('');
                editSelectCliente.css({ opacity: '0.6', cursor: 'not-allowed' });
            } else {
                editSelectCliente.prop('disabled', false);
                editSelectCliente.css({ opacity: '1', cursor: 'pointer' });
            }
        });

        editSelectCliente.off('change').on('change', function () {
            if ($(this).val() !== '') {
                editSelectEmpleado.prop('disabled', true);
                editSelectEmpleado.val('');
                editSelectEmpleado.css({ opacity: '0.6', cursor: 'not-allowed' });
            } else {
                editSelectEmpleado.prop('disabled', false);
                editSelectEmpleado.css({ opacity: '1', cursor: 'pointer' });
            }
        });
    }

    bloquearMutuoEdicion();

    // ========== FUNCIÓN PARA VALIDAR CONTRASEÑA FUERTE ==========
    function validarPasswordFuerte(password) {
        // Mínimo 8 caracteres
        if (password.length < 8) {
            return { valido: false, mensaje: 'La contraseña debe tener al menos 8 caracteres' };
        }
        // Al menos una mayúscula
        if (!/[A-Z]/.test(password)) {
            return { valido: false, mensaje: 'La contraseña debe tener al menos una letra mayúscula (A-Z)' };
        }
        // Al menos un número
        if (!/[0-9]/.test(password)) {
            return { valido: false, mensaje: 'La contraseña debe tener al menos un número (0-9)' };
        }
        // Al menos un símbolo
        if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
            return { valido: false, mensaje: 'La contraseña debe tener al menos un símbolo (!@#$%^&*)' };
        }
        return { valido: true, mensaje: 'Contraseña válida' };
    }

    // ========== CARGAR DATOS AL ABRIR MODAL ==========
    $(document).on('click', '.editar-usuario', function () {
        const id = $(this).data('id');

        $.ajax({
            url: '/admin/usuarios/' + id,
            type: 'GET',
            success: function (data) {
                $('#edit_usuario_id').val(data.id);
                $('#edit_nombre').val(data.name);
                $('#edit_email').val(data.email);
                $('#edit_idRol').val(data.idRol);
                $('#edit_idEmpleado').val(data.idEmpleado);
                $('#edit_idCliente').val(data.idCliente);

                // Restablecer bloqueos según valores iniciales
                if (data.idEmpleado) {
                    editSelectCliente.prop('disabled', true);
                    editSelectCliente.css({ opacity: '0.6', cursor: 'not-allowed' });
                } else if (data.idCliente) {
                    editSelectEmpleado.prop('disabled', true);
                    editSelectEmpleado.css({ opacity: '0.6', cursor: 'not-allowed' });
                } else {
                    editSelectEmpleado.prop('disabled', false);
                    editSelectCliente.prop('disabled', false);
                    editSelectEmpleado.css({ opacity: '1', cursor: 'pointer' });
                    editSelectCliente.css({ opacity: '1', cursor: 'pointer' });
                }

                // Limpiar campo de contraseña al abrir
                $('#edit_password').val('');

                $('#modalEditarUsuario').modal('show');
            },
            error: function (xhr) {
                mostrarToast('Error al cargar los datos del usuario', 'danger');
            }
        });
    });

    // ========== ENVIAR FORMULARIO DE EDICIÓN ==========
    $('#formEditarUsuario').submit(function (e) {
        e.preventDefault();

        // 👇 CORREGIDO: usar el ID correcto del campo
        const nuevaPassword = $('#edit_password').val();

        // Validar contraseña si se ingresó una nueva
        if (nuevaPassword && nuevaPassword.trim() !== '') {
            const validacion = validarPasswordFuerte(nuevaPassword);
            if (!validacion.valido) {
                mostrarToast(validacion.mensaje, 'danger');
                $('#edit_password').focus();
                return;
            }
        }

        const id = $('#edit_usuario_id').val();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.text();
        submitBtn.text('Guardando...').prop('disabled', true);

        $.ajax({
            url: '/admin/usuarios/' + id,
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarToast('Usuario actualizado exitosamente', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarToast(response.message || 'Error al actualizar usuario', 'danger');
                    submitBtn.text(originalText).prop('disabled', false);
                }
            },
            error: function (xhr) {
                let errorMsg = 'Error al actualizar usuario';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                mostrarToast(errorMsg, 'danger');
                submitBtn.text(originalText).prop('disabled', false);
            }
        });
    });

    // ========== LIMPIAR FORMULARIO AL CERRAR ==========
    $('#modalEditarUsuario').on('hidden.bs.modal', function () {
        $('#formEditarUsuario')[0].reset();

        // Restablecer campos de contraseña a tipo password
        $('#edit_password').attr('type', 'password');

        // Restablecer iconos de los ojos
        $('.toggle-password-edit i').removeClass('fa-eye-slash').addClass('fa-eye');

        // Restablecer selects
        editSelectEmpleado.prop('disabled', false).css({ opacity: '1', cursor: 'pointer' });
        editSelectCliente.prop('disabled', false).css({ opacity: '1', cursor: 'pointer' });
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