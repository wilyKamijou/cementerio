// resources/js/modules/dimensiones-editar.js
$(document).ready(function () {
    // Cargar datos al abrir modal
    // En resources/js/modules/espacios-editar.js
    $(document).on('click', '.editar-dimension', function () {
        const id = $(this).data('id');
        $.ajax({
            url: '/admin/dimensiones/' + id,
            type: 'GET',
            success: function (data) {
                // Usar los IDs específicos del modal editar
                $('#edit_dimension_id').val(data.idDim);
                $('#edit_ancho_dim').val(data.ancho);
                $('#edit_largo_dim').val(data.largo);

                // Forzar el cálculo del área
                setTimeout(function () {
                    $('#edit_ancho_dim, #edit_largo_dim').trigger('input');
                }, 100);

                $('#modalEditarDimension').modal('show');
            },
            error: function () {
                mostrarToast('Error al cargar los datos de la dimensión', 'danger');
            }
        });
    });
    // En resources/js/modules/espacios-editar.js
    $(document).on('click', '.editar-dimension', function () {
        const id = $(this).data('id');
        $.ajax({
            url: '/admin/dimensiones/' + id,
            type: 'GET',
            success: function (data) {
                // Usar los IDs específicos del modal editar
                $('#edit_dimension_id').val(data.idDim);
                $('#edit_ancho_dim').val(data.ancho);
                $('#edit_largo_dim').val(data.largo);

                // Forzar el cálculo del área
                setTimeout(function () {
                    $('#edit_ancho_dim, #edit_largo_dim').trigger('input');
                }, 100);

                $('#modalEditarDimension').modal('show');
            },
            error: function () {
                mostrarToast('Error al cargar los datos de la dimensión', 'danger');
            }
        });
    });
    // Enviar formulario de edición
    $('#formEditarDimension').on('submit', function (e) {
        e.preventDefault();
        const id = $('#edit_dimension_id').val();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...').prop('disabled', true);

        $.ajax({
            url: '/admin/dimensiones/' + id,
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    mostrarToast('Dimensión actualizada exitosamente', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarToast(response.message || 'Error al actualizar', 'danger');
                    submitBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function () {
                mostrarToast('Error al actualizar dimensión', 'danger');
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });
    // ========== FUNCIÓN PARA MOSTRAR TOAST (sin iconos) ==========
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
    function calcularAreaEditar() {
        var ancho = parseFloat($('#edit_ancho_dim').val()) || 0;
        var largo = parseFloat($('#edit_largo_dim').val()) || 0;
        var area = (ancho * largo).toFixed(2);

        if (ancho > 0 && largo > 0) {
            $('#previewAreaEditar').text(area);
            $('#previewDimensionEditar').fadeIn();
        } else {
            $('#previewDimensionEditar').fadeOut();
        }
    }

    // Eventos con los IDs únicos
    $('#edit_ancho_dim, #edit_largo_dim').on('input', calcularAreaEditar);

    // Recalcular cuando el modal se abre
    $('#modalEditarDimension').on('shown.bs.modal', function () {
        calcularAreaEditar();
    });
});