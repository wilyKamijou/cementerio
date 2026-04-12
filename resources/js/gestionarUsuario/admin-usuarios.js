// resources/js/admin-usuarios.js

$(document).ready(function () {

    // ========== VARIABLES GLOBALES ==========
    let rolSeleccionadoId = null;

    // ========== FUNCIONES AUXILIARES ==========
    function mostrarLoading() {
        $('body').append('<div class="loading-overlay"><div class="spinner"></div></div>');
    }

    function ocultarLoading() {
        $('.loading-overlay').remove();
    }

    function mostrarMensaje(tipo, mensaje) {
        const alerta = $(`
            <div class="alert alert-${tipo} alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                ${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        $('body').append(alerta);
        setTimeout(() => alerta.fadeOut(), 3000);
    }

    // ========== 1. GESTIÓN DE USUARIOS ==========

    // Abrir modal de crear usuario
    $('#btnCrearUsuario').click(function () {
        $('#modalCrearUsuario').modal('show');
    });

    // Preparar nuevo rol (dentro del modal crear usuario)
    $(document).on('click', '#btnPrepararNuevoRol', function () {
        const nombreRol = $('#nuevoRolNombre').val();
        if (nombreRol) {
            $('#nuevoRolPermisos').slideDown();
            $(this).text('Rol "' + nombreRol + '" listo');
            $(this).prop('disabled', true);
            $(this).removeClass('btn-outline-success').addClass('btn-success');
        } else {
            alert('Ingresa un nombre para el rol');
            $('#nuevoRolNombre').focus();
        }
    });

    // Seleccionar todos los permisos del nuevo rol
    $(document).on('click', '#selectAllNuevosPermisos', function () {
        const todosSeleccionados = $('.nuevo-permiso-checkbox:checked').length === $('.nuevo-permiso-checkbox').length;
        $('.nuevo-permiso-checkbox').prop('checked', !todosSeleccionados);
        $(this).text(todosSeleccionados ? 'Seleccionar todos' : 'Deseleccionar todos');
    });

    // Crear usuario
    $('#formCrearUsuario').submit(function (e) {
        e.preventDefault();
        mostrarLoading();

        $.ajax({
            url: '/admin/usuarios',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarMensaje('success', 'Usuario creado exitosamente');
                    setTimeout(() => location.reload(), 1500);
                }
            },
            error: function (xhr) {
                let mensaje = 'Error al crear usuario';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    mensaje = xhr.responseJSON.message;
                }
                mostrarMensaje('danger', mensaje);
            },
            complete: function () {
                ocultarLoading();
            }
        });
    });

    // Editar usuario
    $(document).on('click', '.editar-usuario', function () {
        const id = $(this).data('id');
        mostrarLoading();

        $.get('/admin/usuarios/' + id, function (data) {
            $('#edit_usuario_id').val(data.id);
            $('#edit_nombre').val(data.name);
            $('#edit_email').val(data.email);
            $('#edit_idRol').val(data.idRol);
            $('#edit_idEmpleado').val(data.idEmpleado);
            $('#edit_idCliente').val(data.idCliente);
            $('#modalEditarUsuario').modal('show');
            ocultarLoading();
        });
    });

    // Actualizar usuario
    $('#formEditarUsuario').submit(function (e) {
        e.preventDefault();
        const id = $('#edit_usuario_id').val();
        mostrarLoading();

        $.ajax({
            url: '/admin/usuarios/' + id,
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarMensaje('success', 'Usuario actualizado exitosamente');
                    setTimeout(() => location.reload(), 1500);
                }
            },
            error: function () {
                mostrarMensaje('danger', 'Error al actualizar usuario');
            },
            complete: function () {
                ocultarLoading();
            }
        });
    });

    // Eliminar usuario
    $(document).on('click', '.eliminar-usuario', function () {
        const id = $(this).data('id');
        if (confirm('¿Estás seguro de eliminar este usuario?')) {
            mostrarLoading();
            $.ajax({
                url: '/admin/usuarios/' + id,
                type: 'DELETE',
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function (response) {
                    if (response.success) {
                        mostrarMensaje('success', 'Usuario eliminado exitosamente');
                        setTimeout(() => location.reload(), 1500);
                    }
                },
                error: function () {
                    mostrarMensaje('danger', 'Error al eliminar usuario');
                },
                complete: function () {
                    ocultarLoading();
                }
            });
        }
    });

    // ========== 2. GESTIÓN DE ROLES ==========

    // Abrir modal de crear rol
    $('#btnCrearRol').click(function () {
        $('#modalCrearRol').modal('show');
    });

    // Seleccionar todos los permisos en crear rol
    $(document).on('click', '#selectAllPermisosRol', function () {
        const todos = $('.permiso-checkbox:checked').length === $('.permiso-checkbox').length;
        $('.permiso-checkbox').prop('checked', !todos);
        $(this).text(todos ? 'Seleccionar todos' : 'Deseleccionar todos');
    });

    // Crear rol
    $('#formCrearRol').submit(function (e) {
        e.preventDefault();
        mostrarLoading();

        $.ajax({
            url: '/admin/roles',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarMensaje('success', 'Rol creado exitosamente');
                    setTimeout(() => location.reload(), 1500);
                }
            },
            error: function () {
                mostrarMensaje('danger', 'Error al crear rol');
            },
            complete: function () {
                ocultarLoading();
            }
        });
    });

    // Editar permisos de un rol
    $(document).on('click', '.editar-permisos-rol', function () {
        const id = $(this).data('id');
        rolSeleccionadoId = id;
        mostrarLoading();

        $.get('/admin/roles/' + id + '/permisos', function (data) {
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

            $('#modalEditarPermisosRol').modal('show');
            ocultarLoading();
        });
    });

    // Seleccionar todos en editar permisos
    $(document).on('click', '#selectAllPermisosEdit', function () {
        $('.permiso-checkbox').prop('checked', true);
    });

    $(document).on('click', '#deselectAllPermisosEdit', function () {
        $('.permiso-checkbox').prop('checked', false);
    });

    // Actualizar permisos del rol
    $('#formEditarPermisosRol').submit(function (e) {
        e.preventDefault();
        const id = $('#edit_rol_id').val();
        mostrarLoading();

        $.ajax({
            url: '/admin/roles/' + id,
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarMensaje('success', 'Permisos actualizados exitosamente');
                    $('#modalEditarPermisosRol').modal('hide');
                    setTimeout(() => location.reload(), 1500);
                }
            },
            error: function () {
                mostrarMensaje('danger', 'Error al actualizar permisos');
            },
            complete: function () {
                ocultarLoading();
            }
        });
    });

    // ========== 3. GESTIÓN DE PERMISOS ==========

    // Abrir modal de crear permiso
    $('#btnCrearPermiso').click(function () {
        $('#modalCrearPermiso').modal('show');
    });

    // Crear permiso
    $('#formCrearPermiso').submit(function (e) {
        e.preventDefault();
        mostrarLoading();

        $.ajax({
            url: '/admin/permisos',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarMensaje('success', 'Permiso creado exitosamente');
                    setTimeout(() => location.reload(), 1500);
                }
            },
            error: function () {
                mostrarMensaje('danger', 'Error al crear permiso');
            },
            complete: function () {
                ocultarLoading();
            }
        });
    });

    // ========== 4. FUNCIONES ADICIONALES ==========

    // Buscar usuario en tiempo real
    $('#buscarUsuario').on('keyup', function () {
        const valor = $(this).val().toLowerCase();
        $('.fila-usuario').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1);
        });
    });
});