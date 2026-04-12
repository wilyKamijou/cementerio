// resources/js/modals/empleado-crear.js

$(document).ready(function () {

    // ========== ABRIR MODAL ==========
    $('#btnCrearEmpleado').on('click', function (e) {
        e.preventDefault();
        $('#modalCrearEmpleado').modal('show');
    });

    // ========== ENVIAR FORMULARIO ==========
    $('#formCrearEmpleado').on('submit', function (e) {
        e.preventDefault();

        // Validaciones
        const nombre = $('input[name="nombre"]').val().trim();
        const paterno = $('input[name="paterno"]').val().trim();
        const telefono = $('input[name="telefono"]').val().trim();

        if (!nombre) {
            alert('El nombre es requerido');
            $('input[name="nombre"]').focus();
            return;
        }

        if (!paterno) {
            alert('El apellido paterno es requerido');
            $('input[name="paterno"]').focus();
            return;
        }

        if (!telefono) {
            alert('El teléfono es requerido');
            $('input[name="telefono"]').focus();
            return;
        }

        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...').prop('disabled', true);

        $.ajax({
            url: '/admin/empleados',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    alert('✅ Empleado creado exitosamente');
                    location.reload();
                } else {
                    alert('❌ Error: ' + (response.message || 'No se pudo crear el empleado'));
                    submitBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function (xhr) {
                let errorMsg = '❌ Error al crear empleado';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                alert(errorMsg);
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // ========== LIMPIAR FORMULARIO AL CERRAR ==========
    $('#modalCrearEmpleado').on('hidden.bs.modal', function () {
        $('#formCrearEmpleado')[0].reset();
    });
});