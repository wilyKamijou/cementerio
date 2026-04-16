// resources/js/modals/direccion-crear.js

$(document).ready(function () {
    function mostrarToast(mensaje, tipo) {
        $('.toast-notification').remove();

        const icono = tipo === 'success' ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-exclamation-circle"></i>';
        const toast = $(`
            <div class="toast-notification toast-${tipo}">
                ${icono}
                <span>${mensaje}</span>
            </div>
        `);
        $('body').append(toast);
        setTimeout(() => {
            toast.fadeOut(300, function () { $(this).remove(); });
        }, 3000);
    }

    $('#btnCrearDireccion').click(function () {
        $('#modalCrearDireccion').modal('show');
    });

    $('#formCrearDireccion').submit(function (e) {
        e.preventDefault();

        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...').prop('disabled', true);

        $.ajax({
            url: '/admin/direcciones',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarToast('Dirección creada exitosamente', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarToast(response.message || 'Error al crear dirección', 'danger');
                    submitBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function (xhr) {
                let mensaje = 'Error al crear dirección';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    mensaje = xhr.responseJSON.message;
                }
                mostrarToast(mensaje, 'danger');
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    function actualizarPreview() {
        var seccion = $('input[name="seccion"]').val();
        var numero = $('input[name="numero"]').val();
        var calle = $('input[name="calle"]').val();
        var fila = $('input[name="fila"]').val();

        if (seccion && numero && calle && fila) {
            var direccionCompleta = `Sección ${seccion} - N° ${numero}, Calle ${calle}, Fila ${fila}`;
            $('#previewTexto').text(direccionCompleta);
            $('#previewDireccion').fadeIn();
        } else {
            $('#previewDireccion').fadeOut();
        }
    }

    $('input[name="seccion"], input[name="numero"], input[name="calle"], input[name="fila"]').on('input',
        actualizarPreview);
});


