// resources/js/modals/usuario-editar.js

// Modal Editar Usuario
$(document).ready(function () {

    // Cargar datos al abrir modal (se usa event delegation por si hay elementos dinámicos)
    $(document).on('click', '.editar-usuario', function () {
        const id = $(this).data('id');

        $.get('/admin/usuarios/' + id, function (data) {
            $('#edit_usuario_id').val(data.id);
            $('#edit_nombre').val(data.name);
            $('#edit_email').val(data.email);
            $('#edit_idRol').val(data.idRol);
            $('#edit_idEmpleado').val(data.idEmpleado);
            $('#edit_idCliente').val(data.idCliente);
            $('#modalEditarUsuario').modal('show');
        });
    });

    // Enviar formulario de edición
    $('#formEditarUsuario').submit(function (e) {
        e.preventDefault();
        const id = $('#edit_usuario_id').val();

        $.ajax({
            url: '/admin/usuarios/' + id,
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    alert('Usuario actualizado exitosamente');
                    location.reload();
                }
            },
            error: function () {
                alert('Error al actualizar usuario');
            }
        });
    });
});