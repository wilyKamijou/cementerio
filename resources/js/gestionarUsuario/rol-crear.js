// resources/js/modals/rol-crear.js

// Modal Crear Rol
$(document).ready(function () {

    // Abrir modal
    $('#btnCrearRol').click(function () {
        $('#modalCrearRol').modal('show');
    });

    // Seleccionar todos los permisos
    $(document).on('click', '#selectAllPermisosRol', function () {
        const todos = $('.permiso-checkbox:checked').length === $('.permiso-checkbox').length;
        $('.permiso-checkbox').prop('checked', !todos);
        $(this).text(todos ? 'Seleccionar todos' : 'Deseleccionar todos');
    });

    // Enviar formulario
    $('#formCrearRol').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: '/admin/roles',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    alert('Rol creado exitosamente');
                    location.reload();
                }
            },
            error: function () {
                alert('Error al crear rol');
            }
        });
    });
});