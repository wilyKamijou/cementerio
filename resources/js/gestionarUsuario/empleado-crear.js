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

        // 👇 IMPORTANTE: Buscar SOLO dentro de este formulario
        const form = $(this);

        const nombre = form.find('input[name="nombre"]').val().trim();
        const paterno = form.find('input[name="paterno"]').val().trim();
        const telefono = form.find('input[name="telefono"]').val().trim();

        // Debug
        console.log('Nombre (dentro del form):', nombre);
        console.log('Paterno (dentro del form):', paterno);
        console.log('Teléfono (dentro del form):', telefono);

        if (!nombre) {
            alert('El nombre es requerido');
            form.find('input[name="nombre"]').focus();
            return;
        }

        if (!paterno) {
            alert('El apellido paterno es requerido');
            form.find('input[name="paterno"]').focus();
            return;
        }

        if (!telefono) {
            alert('El teléfono es requerido');
            form.find('input[name="telefono"]').focus();
            return;
        }

        const submitBtn = form.find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...').prop('disabled', true);

        $.ajax({
            url: '/admin/empleados',
            type: 'POST',
            data: form.serialize(),
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