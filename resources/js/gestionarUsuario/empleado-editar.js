// resources/js/modals/empleado-editar.js

$(document).ready(function () {

    function mostrarToast(mensaje, tipo) {
        $('.toast-notification').remove();
        const toast = $(`
            <div class="toast-notification toast-${tipo}">
                <span>${mensaje}</span>
            </div>
        `);
        $('body').append(toast);
        setTimeout(() => {
            toast.fadeOut(300, function () { $(this).remove(); });
        }, 3000);
    }

    // ========== VALIDAR TELÉFONO ==========
    function validarTelefono(telefono) {
        const telefonoLimpio = telefono.replace(/[\s-]/g, '');
        if (!/^\d+$/.test(telefonoLimpio)) {
            return { valido: false, mensaje: 'El teléfono solo debe contener números' };
        }
        if (telefonoLimpio.length < 8 || telefonoLimpio.length > 15) {
            return { valido: false, mensaje: 'El teléfono debe tener entre 8 y 15 dígitos' };
        }
        return { valido: true, mensaje: '' };
    }

    // ========== CARGAR DATOS AL ABRIR MODAL ==========
    $(document).on('click', '.editar-empleado', function () {
        const id = $(this).data('id');

        $.ajax({
            url: '/admin/empleados/' + id,
            type: 'GET',
            success: function (data) {

                $('#edit_empleado_id').val(data.idEmpleado);
                $('#edit_nombre_empleado').val(data.nombre);
                $('#edit_paterno_empleado').val(data.paterno);
                $('#edit_materno_empleado').val(data.materno || '');
                $('#edit_telefono_empleado').val(data.telefono);
                $('#edit_direccion_empleado').val(data.direccion || '');
                $('#modalEditarEmpleado').modal('show');
            },
            error: function () {
                mostrarToast('Error al cargar los datos del empleado', 'danger');
            }
        });
    });

    // ========== ENVIAR FORMULARIO DE EDICIÓN ==========
    $('#formEditarEmpleado').on('submit', function (e) {
        e.preventDefault();

        const nombre = $('#edit_nombre_empleado').val().trim();
        const paterno = $('#edit_paterno_empleado').val().trim();
        const telefono = $('#edit_telefono_empleado').val().trim();

        if (!nombre) {
            mostrarToast('El nombre es requerido', 'danger');
            $('#edit_nombre_empleado').focus();
            return;
        }

        if (!paterno) {
            mostrarToast('El apellido paterno es requerido', 'danger');
            $('#edit_paterno_empleado').focus();
            return;
        }

        if (!telefono) {
            mostrarToast('El teléfono es requerido', 'danger');
            $('#edit_telefono_empleado').focus();
            return;
        }

        const validacionTelefono = validarTelefono(telefono);
        if (!validacionTelefono.valido) {
            mostrarToast(validacionTelefono.mensaje, 'danger');
            $('#edit_telefono_empleado').focus();
            return;
        }

        const id = $('#edit_empleado_id').val();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...').prop('disabled', true);

        $.ajax({
            url: '/admin/empleados/' + id,
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarToast('Empleado actualizado exitosamente', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarToast(response.message || 'Error al actualizar empleado', 'danger');
                    submitBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function (xhr) {
                let errorMsg = 'Error al actualizar empleado';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                mostrarToast(errorMsg, 'danger');
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // ========== LIMPIAR FORMULARIO AL CERRAR ==========
    $('#modalEditarEmpleado').on('hidden.bs.modal', function () {
        $('#formEditarEmpleado')[0].reset();
    });
});