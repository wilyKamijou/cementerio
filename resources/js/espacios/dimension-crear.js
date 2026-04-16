// resources/js/modals/dimension-crear.js

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

    $('#btnCrearDimension').click(function () {
        $('#modalCrearDimension').modal('show');
    });

    $('#formCrearDimension').submit(function (e) {
        e.preventDefault();

        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...').prop('disabled', true);

        $.ajax({
            url: '/admin/dimensiones',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarToast('Dimensión creada exitosamente', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarToast(response.message || 'Error al crear dimensión', 'danger');
                    submitBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function (xhr) {
                let mensaje = 'Error al crear dimensión';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    mensaje = xhr.responseJSON.message;
                }
                mostrarToast(mensaje, 'danger');
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });
});
// Script opcional para calcular y mostrar el área en tiempo real
$(document).ready(function () {
    function calcularArea() {
        var ancho = parseFloat($('input[name="ancho"]').val()) || 0;
        var largo = parseFloat($('input[name="largo"]').val()) || 0;
        var area = (ancho * largo).toFixed(2);

        if (ancho > 0 && largo > 0) {
            $('#previewArea').text(area);
            $('#previewDimension').fadeIn();
        } else {
            $('#previewDimension').fadeOut();
        }
    }

    $('input[name="ancho"], input[name="largo"]').on('input', calcularArea);
});
