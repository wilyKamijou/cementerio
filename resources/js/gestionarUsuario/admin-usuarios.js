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

    // // ========== 3. GESTIÓN DE ROLES ==========


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
    // Pestañas manuales
    document.querySelectorAll('[data-tab]').forEach(button => {
        button.addEventListener('click', function () {
            const tabId = this.getAttribute('data-tab');

            // Cambiar estilo de botones
            document.querySelectorAll('[data-tab]').forEach(btn => {
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-outline-primary');
            });
            this.classList.remove('btn-outline-primary');
            this.classList.add('btn-primary');

            // Mostrar contenido correspondiente
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.style.display = 'none';
            });
            document.getElementById(`tab-${tabId}`).style.display = 'block';
        });
    });

    // Buscar permiso
    $('#buscarPermiso').on('keyup', function () {
        const valor = $(this).val().toLowerCase();
        $('.fila-permiso').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1);
        });
    });
    // Buscar en tabla rol-permisos
    $('#buscarRolPermiso').on('keyup', function () {
        const valor = $(this).val().toLowerCase();
        $('.fila-rol-permiso').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1);
        });
    });

});