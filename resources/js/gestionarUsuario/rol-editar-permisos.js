// resources/js/modals/rol-editar-permisos.js

// Modal Editar Permisos de Rol
$(document).ready(function () {

    // Cargar datos al abrir modal
    $(document).on('click', '.editar-permisos-rol', function () {
        const id = $(this).data('id');

        $.get('/admin/roles/' + id + '/permisos', function (data) {
            $('#edit_rol_id').val(data.rol.idRol);
            $('#edit_rol_nombre').val(data.rol.nombre);
            $('#edit_rol_descripcion').val(data.rol.descripcion);

            // Marcar permisos asignados
            $('.permiso-checkbox').each(function () {
                const permisoId = parseInt($(this).val());
                $(this).prop('checked', data.permisos_asignados.includes(permisoId));
            });

            $('#modalEditarPermisosRol').modal('show');
        });
    });

    // Seleccionar/deseleccionar todos
    $(document).on('click', '#selectAllPermisosEdit', function () {
        $('.permiso-checkbox').prop('checked', true);
    });

    $(document).on('click', '#deselectAllPermisosEdit', function () {
        $('.permiso-checkbox').prop('checked', false);
    });

    // Enviar formulario
    $('#formEditarPermisosRol').submit(function (e) {
        e.preventDefault();
        const id = $('#edit_rol_id').val();

        $.ajax({
            url: '/admin/roles/' + id,
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    alert('Permisos actualizados exitosamente');
                    $('#modalEditarPermisosRol').modal('hide');
                    location.reload();
                }
            },
            error: function () {
                alert('Error al actualizar permisos');
            }
        });
    });
});