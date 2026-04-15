// resources/js/modals/usuario-crear.js

$(document).ready(function () {

    // ========== ABRIR MODAL ==========
    $('#btnCrearUsuario').on('click', function (e) {
        e.preventDefault();
        $('#modalCrearUsuario').modal('show');
    });

    // ========== MOSTRAR/OCULTAR CONTRASEÑA ==========
    $(document).on('click', '.toggle-password', function () {
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
    const selectEmpleado = $('#selectEmpleado');
    const selectCliente = $('#selectCliente');

    function bloquearMutuo() {
        selectEmpleado.off('change').on('change', function () {
            if ($(this).val() !== '') {
                selectCliente.prop('disabled', true);
                selectCliente.val('');
                selectCliente.css({ opacity: '0.6', cursor: 'not-allowed' });
            } else {
                selectCliente.prop('disabled', false);
                selectCliente.css({ opacity: '1', cursor: 'pointer' });
            }
        });

        selectCliente.off('change').on('change', function () {
            if ($(this).val() !== '') {
                selectEmpleado.prop('disabled', true);
                selectEmpleado.val('');
                selectEmpleado.css({ opacity: '0.6', cursor: 'not-allowed' });
            } else {
                selectEmpleado.prop('disabled', false);
                selectEmpleado.css({ opacity: '1', cursor: 'pointer' });
            }
        });
    }

    bloquearMutuo();

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
        return { valido: true, mensaje: '' };
    }

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
            mostrarToast('Ingresa un nombre para el rol', 'warning');
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
        const password = $('#password').val();
        const passwordConfirm = $('#password_confirmation').val();

        if (!nombre) {
            mostrarToast('El nombre completo es requerido', 'danger');
            $('input[name="name"]').focus();
            return;
        }

        if (!email) {
            mostrarToast('El email es requerido', 'danger');
            $('input[name="email"]').focus();
            return;
        }

        if (!password) {
            mostrarToast('La contraseña es requerida', 'danger');
            $('#password').focus();
            return;
        }

        if (password !== passwordConfirm) {
            mostrarToast('Las contraseñas no coinciden', 'danger');
            $('#password').focus();
            return;
        }

        // 👇 VALIDACIÓN DE CONTRASEÑA FUERTE
        const validacion = validarPasswordFuerte(password);
        if (!validacion.valido) {
            mostrarToast(validacion.mensaje, 'danger');
            $('#password').focus();
            return;
        }

        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.text();
        submitBtn.text('Guardando...').prop('disabled', true);

        $.ajax({
            url: '/admin/usuarios',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarToast(response.message, 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarToast(response.message, 'danger');
                    submitBtn.text(originalText).prop('disabled', false);
                }
            },
            error: function (xhr) {
                let errorMsg = 'Error al crear usuario';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                mostrarToast(errorMsg, 'danger');
                submitBtn.text(originalText).prop('disabled', false);
            }
        });
    });

    // ========== LIMPIAR FORMULARIO AL CERRAR ==========
    $('#modalCrearUsuario').on('hidden.bs.modal', function () {
        $('#formCrearUsuario')[0].reset();
        $('#password, #password_confirmation').attr('type', 'password');
        $('.toggle-password i').removeClass('fa-eye-slash').addClass('fa-eye');
        selectEmpleado.prop('disabled', false).css({ opacity: '1', cursor: 'pointer' });
        selectCliente.prop('disabled', false).css({ opacity: '1', cursor: 'pointer' });
        $('#nuevoRolPermisos').hide();
        $('#btnPrepararNuevoRol').text('Preparar').prop('disabled', false).removeClass('btn-success').addClass('btn-outline-success');
        $('#nuevoRolNombre').val('');
    });

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
});