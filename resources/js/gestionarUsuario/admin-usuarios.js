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

    // Crear usuario
    $('#formCrearUsuario').submit(function (e) {
        e.preventDefault();
        mostrarLoading();

        $.ajax({
            url: '/admin/gestionarUsuarios',
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

        $.get('/admin/gestionarUsuarios/' + id, function (data) {
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
            url: '/admin/gestionarUsuarios/' + id,
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
                url: '/admin/gestionarUsuarios/' + id,
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

    // Buscar usuario
    $('#buscarUsuario').on('keyup', function () {
        const valor = $(this).val().toLowerCase();
        $('.fila-usuario').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1);
        });
    });

    // ========== 2. GESTIÓN DE EMPLEADOS ==========

    // Eliminar empleado
    $(document).on('click', '.eliminar-empleado', function () {
        const id = $(this).data('id');
        if (confirm('¿Estás seguro de eliminar este empleado?')) {
            mostrarLoading();
            $.ajax({
                url: '/admin/empleados/' + id,
                type: 'DELETE',
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function (response) {
                    if (response.success) {
                        mostrarMensaje('success', 'Empleado eliminado exitosamente');
                        setTimeout(() => location.reload(), 1500);
                    }
                },
                error: function () {
                    mostrarMensaje('danger', 'Error al eliminar empleado');
                },
                complete: function () {
                    ocultarLoading();
                }
            });
        }
    });

    // Buscar empleado
    $('#buscarEmpleado').on('keyup', function () {
        const valor = $(this).val().toLowerCase();
        $('.fila-empleado').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1);
        });
    });

    // ========== 3. GESTIÓN DE ROLES ==========

    // Abrir modal de crear rol
    $('#btnCrearRol').click(function () {
        $('#modalCrearRol').modal('show');
    });

    // Crear rol
    $('#formCrearRol').submit(function (e) {
        e.preventDefault();
        mostrarLoading();

        $.ajax({
            url: '/admin/gestionarUsuarios/roles',
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

        $.get('/admin/gestionarUsuarios/roles/' + id + '/permisos', function (data) {
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

    // Actualizar permisos del rol
    $('#formEditarPermisosRol').submit(function (e) {
        e.preventDefault();
        const id = $('#edit_rol_id').val();
        mostrarLoading();

        $.ajax({
            url: '/admin/gestionarUsuarios/roles/' + id,
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

    // Eliminar rol
    $(document).on('click', '.eliminar-rol', function () {
        const id = $(this).data('id');
        if (confirm('¿Estás seguro de eliminar este rol?')) {
            mostrarLoading();
            $.ajax({
                url: '/admin/gestionarUsuarios/roles/' + id,
                type: 'DELETE',
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function (response) {
                    if (response.success) {
                        mostrarMensaje('success', 'Rol eliminado exitosamente');
                        setTimeout(() => location.reload(), 1500);
                    }
                },
                error: function () {
                    mostrarMensaje('danger', 'Error al eliminar rol');
                },
                complete: function () {
                    ocultarLoading();
                }
            });
        }
    });

    // Buscar rol
    $('#buscarRol').on('keyup', function () {
        const valor = $(this).val().toLowerCase();
        $('.fila-rol').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1);
        });
    });

    // ========== 4. GESTIÓN DE PERMISOS ==========

    // Abrir modal de crear permiso
    $('#btnCrearPermiso').click(function () {
        $('#modalCrearPermiso').modal('show');
    });

    // Crear permiso
    $('#formCrearPermiso').submit(function (e) {
        e.preventDefault();
        mostrarLoading();

        $.ajax({
            url: '/admin/gestionarUsuarios/permisos',
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

    // Eliminar permiso
    $(document).on('click', '.eliminar-permiso', function () {
        const id = $(this).data('id');
        if (confirm('¿Estás seguro de eliminar este permiso?')) {
            mostrarLoading();
            $.ajax({
                url: '/admin/permisos/' + id,
                type: 'DELETE',
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function (response) {
                    if (response.success) {
                        mostrarMensaje('success', 'Permiso eliminado exitosamente');
                        setTimeout(() => location.reload(), 1500);
                    }
                },
                error: function () {
                    mostrarMensaje('danger', 'Error al eliminar permiso');
                },
                complete: function () {
                    ocultarLoading();
                }
            });
        }
    });

    // Buscar permiso
    $('#buscarPermiso').on('keyup', function () {
        const valor = $(this).val().toLowerCase();
        $('.fila-permiso').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1);
        });
    });
});