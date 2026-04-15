// resources/js/modals/empleado-crear.js

$(document).ready(function () {

    // ========== ABRIR MODAL ==========
    $('#btnCrearEmpleado').on('click', function (e) {
        e.preventDefault();
        $('#modalCrearEmpleado').modal('show');
    });

    // ========== FUNCIÓN PARA MOSTRAR TOAST ==========
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

    // ========== FUNCIÓN PARA VALIDAR TELÉFONO ==========
    function validarTelefono(telefono) {
        const telefonoLimpio = telefono.replace(/[\s-]/g, '');

        if (!/^\d+$/.test(telefonoLimpio)) {
            return { valido: false, mensaje: 'El teléfono solo debe contener números' };
        }

        if (telefonoLimpio.length < 8) {
            return { valido: false, mensaje: 'El teléfono debe tener al menos 8 dígitos' };
        }

        if (telefonoLimpio.length > 15) {
            return { valido: false, mensaje: 'El teléfono no puede tener más de 15 dígitos' };
        }

        return { valido: true, mensaje: '' };
    }

    // ========== FUNCIÓN PARA VALIDAR NOMBRE ==========
    function validarSoloLetras(texto, campo) {
        const soloLetras = /^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s]+$/;
        if (!soloLetras.test(texto)) {
            return { valido: false, mensaje: `${campo} solo debe contener letras` };
        }
        return { valido: true, mensaje: '' };
    }

    // ========== ENVIAR FORMULARIO ==========
    $('#formCrearEmpleado').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const nombre = form.find('input[name="nombre"]').val().trim();
        const paterno = form.find('input[name="paterno"]').val().trim();
        const materno = form.find('input[name="materno"]').val().trim();
        const telefono = form.find('input[name="telefono"]').val().trim();

        // Validación de nombre
        if (!nombre) {
            mostrarToast('El nombre es requerido', 'danger');
            form.find('input[name="nombre"]').focus();
            return;
        }

        const validarNombre = validarSoloLetras(nombre, 'El nombre');
        if (!validarNombre.valido) {
            mostrarToast(validarNombre.mensaje, 'danger');
            form.find('input[name="nombre"]').focus();
            return;
        }

        if (!paterno) {
            mostrarToast('El apellido paterno es requerido', 'danger');
            form.find('input[name="paterno"]').focus();
            return;
        }

        const validarPaterno = validarSoloLetras(paterno, 'El apellido paterno');
        if (!validarPaterno.valido) {
            mostrarToast(validarPaterno.mensaje, 'danger');
            form.find('input[name="paterno"]').focus();
            return;
        }

        if (materno) {
            const validarMaterno = validarSoloLetras(materno, 'El apellido materno');
            if (!validarMaterno.valido) {
                mostrarToast(validarMaterno.mensaje, 'danger');
                form.find('input[name="materno"]').focus();
                return;
            }
        }

        if (!telefono) {
            mostrarToast('El teléfono es requerido', 'danger');
            form.find('input[name="telefono"]').focus();
            return;
        }

        const validacionTelefono = validarTelefono(telefono);
        if (!validacionTelefono.valido) {
            mostrarToast(validacionTelefono.mensaje, 'danger');
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
                    mostrarToast('Empleado creado exitosamente', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarToast(response.message || 'No se pudo crear el empleado', 'danger');
                    submitBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function (xhr) {
                let errorMsg = 'Error al crear empleado';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                mostrarToast(errorMsg, 'danger');
                // 👇 IMPORTANTE: Restablecer el botón en caso de error
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // ========== LIMPIAR FORMULARIO AL CERRAR ==========
    $('#modalCrearEmpleado').on('hidden.bs.modal', function () {
        $('#formCrearEmpleado')[0].reset();
        // Restablecer el botón por si acaso
        const submitBtn = $('#formCrearEmpleado').find('button[type="submit"]');
        submitBtn.html('<i class="fas fa-save"></i> Guardar Empleado').prop('disabled', false);
    });
});