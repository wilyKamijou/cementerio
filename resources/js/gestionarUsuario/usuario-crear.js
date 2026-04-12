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
            alert('Ingresa un nombre para el rol');
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

        // Validaciones
        const nombre = $('input[name="name"]').val().trim();
        const email = $('input[name="email"]').val().trim();
        const password = $('input[name="password"]').val();
        const passwordConfirm = $('input[name="password_confirmation"]').val();

        if (!nombre) {
            alert('El nombre completo es requerido');
            $('input[name="name"]').focus();
            return;
        }

        if (!email) {
            alert('El email es requerido');
            $('input[name="email"]').focus();
            return;
        }

        if (!password) {
            alert('La contraseña es requerida');
            $('input[name="password"]').focus();
            return;
        }

        if (password !== passwordConfirm) {
            alert('Las contraseñas no coinciden');
            $('input[name="password"]').focus();
            return;
        }

        // Deshabilitar botón mientras se envía
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.text();
        submitBtn.text('Guardando...').prop('disabled', true);

        $.ajax({
            url: '/admin/usuarios',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    alert('Usuario creado exitosamente');
                    location.reload();
                } else {
                    alert('Error: ' + (response.message || 'No se pudo crear el usuario'));
                    submitBtn.text(originalText).prop('disabled', false);
                }
            },
            error: function (xhr) {
                let errorMsg = 'Error al crear usuario';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                alert(errorMsg);
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
});