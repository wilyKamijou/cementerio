// resources/js/modals/permiso-crear.js

// Modal Crear Permiso
$(document).ready(function () {

    // Abrir modal
    $('#btnCrearPermiso').click(function () {
        $('#modalCrearPermiso').modal('show');
    });

    // Enviar formulario
    $('#formCrearPermiso').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: '/admin/permisos',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    alert('Permiso creado exitosamente');
                    location.reload();
                }
            },
            error: function () {
                alert('Error al crear permiso');
            }
        });
    });
});