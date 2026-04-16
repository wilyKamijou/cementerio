// resources/js/modules/espacios.js

// ========== PESTAÑAS ==========
document.querySelectorAll('[data-tab]').forEach(button => {
    button.addEventListener('click', function () {
        const tabId = this.getAttribute('data-tab');
        document.querySelectorAll('[data-tab]').forEach(btn => {
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-outline-primary');
        });
        this.classList.remove('btn-outline-primary');
        this.classList.add('btn-primary');
        document.querySelectorAll('.tab-pane').forEach(pane => {
            pane.style.display = 'none';
        });
        document.getElementById(`tab-${tabId}`).style.display = 'block';
    });
});

// ========== FUNCIONES AUXILIARES ==========
function mostrarToast(mensaje, tipo) {
    const toast = document.createElement('div');
    toast.className = `toast-notification toast-${tipo}`;
    toast.innerHTML = `<span>${mensaje}</span>`;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 12px 20px;
        border-radius: 8px;
        font-size: 14px;
        z-index: 9999;
        background: ${tipo === 'success' ? '#d4edda' : '#f8d7da'};
        color: ${tipo === 'success' ? '#155724' : '#721c24'};
        border-left: 4px solid ${tipo === 'success' ? '#28a745' : '#dc3545'};
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        animation: slideInRight 0.3s ease;
    `;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// ========== BUSCADORES ==========

// Buscador de Espacios - filtra por ID, Precio, Estado, Dirección, Dimensiones, Cementerio
const buscarEspacio = document.getElementById('buscarEspacio');
if (buscarEspacio) {
    buscarEspacio.addEventListener('keyup', function () {
        const valor = this.value.toLowerCase();
        const filas = document.querySelectorAll('.fila-espacio');
        filas.forEach(fila => {
            const texto = fila.textContent.toLowerCase();
            fila.style.display = texto.includes(valor) ? '' : 'none';
        });
    });
}

// Buscador de Cementerios - filtra por ID, Nombre, Estado, Localización, Espacios Disponibles
const buscarCementerio = document.getElementById('buscarCementerio');
if (buscarCementerio) {
    buscarCementerio.addEventListener('keyup', function () {
        const valor = this.value.toLowerCase();
        const filas = document.querySelectorAll('.fila-cementerio');
        filas.forEach(fila => {
            const texto = fila.textContent.toLowerCase();
            fila.style.display = texto.includes(valor) ? '' : 'none';
        });
    });
}

// Buscador de Dimensiones - filtra por ID, Ancho, Largo, Área
const buscarDimension = document.getElementById('buscarDimension');
if (buscarDimension) {
    buscarDimension.addEventListener('keyup', function () {
        const valor = this.value.toLowerCase();
        const filas = document.querySelectorAll('.fila-dimension');
        filas.forEach(fila => {
            const texto = fila.textContent.toLowerCase();
            fila.style.display = texto.includes(valor) ? '' : 'none';
        });
    });
}

// Buscador de Direcciones - filtra por ID, Sección, Número, Calle, Fila
const buscarDireccion = document.getElementById('buscarDireccion');
if (buscarDireccion) {
    buscarDireccion.addEventListener('keyup', function () {
        const valor = this.value.toLowerCase();
        const filas = document.querySelectorAll('.fila-direccion');
        filas.forEach(fila => {
            const texto = fila.textContent.toLowerCase();
            fila.style.display = texto.includes(valor) ? '' : 'none';
        });
    });
}

// ========== FUNCIONES CRUD ==========

// ===== ESPACIOS =====
function cargarEspacio(id) {
    fetch(`/admin/espacios/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_espacio_id').value = data.idEspacio;
            document.getElementById('edit_precio').value = data.precio;
            document.getElementById('edit_estado').value = data.estado;
            document.getElementById('edit_idDir').value = data.idDir;
            document.getElementById('edit_idDim').value = data.idDim;
            document.getElementById('edit_idCem').value = data.idCem;
            new bootstrap.Modal(document.getElementById('modalEditarEspacio')).show();
        })
        .catch(error => console.error('Error:', error));
}

function eliminarEspacio(id) {
    if (confirm('¿Estás seguro de eliminar este espacio?')) {
        fetch(`/admin/espacios/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarToast('Espacio eliminado exitosamente', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarToast(data.message || 'Error al eliminar espacio', 'danger');
                }
            })
            .catch(error => mostrarToast('Error al eliminar espacio', 'danger'));
    }
}

// ===== CEMENTERIOS =====
function cargarCementerio(id) {
    fetch(`/admin/cementerios/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_cementerio_id').val(data.idCem);
            document.getElementById('edit_nombre_cementerio').val(data.nombre);
            document.getElementById('edit_estado_cementerio').val(data.estado);
            document.getElementById('edit_localizacion').val(data.localizacion || '');
            document.getElementById('edit_espacioDisp').val(data.espacioDisp || '');
            new bootstrap.Modal(document.getElementById('modalEditarCementerio')).show();
        })
        .catch(error => console.error('Error:', error));
}

function eliminarCementerio(id) {
    if (confirm('¿Estás seguro de eliminar este cementerio?')) {
        fetch(`/admin/cementerios/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarToast('Cementerio eliminado exitosamente', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarToast(data.message || 'Error al eliminar cementerio', 'danger');
                }
            })
            .catch(error => mostrarToast('Error al eliminar cementerio', 'danger'));
    }
}

// ===== DIMENSIONES =====
function cargarDimension(id) {
    fetch(`/admin/dimensiones/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_dimension_id').val(data.idDim);
            document.getElementById('edit_ancho').val(data.ancho);
            document.getElementById('edit_largo').val(data.largo);
            new bootstrap.Modal(document.getElementById('modalEditarDimension')).show();
        })
        .catch(error => console.error('Error:', error));
}

function eliminarDimension(id) {
    if (confirm('¿Estás seguro de eliminar esta dimensión?')) {
        fetch(`/admin/dimensiones/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarToast('Dimensión eliminada exitosamente', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarToast(data.message || 'Error al eliminar dimensión', 'danger');
                }
            })
            .catch(error => mostrarToast('Error al eliminar dimensión', 'danger'));
    }
}

// ===== DIRECCIONES =====
function cargarDireccion(id) {
    fetch(`/admin/direcciones/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_direccion_id').val(data.idDir);
            document.getElementById('edit_seccion').val(data.seccion);
            document.getElementById('edit_numero').val(data.numero);
            document.getElementById('edit_calle').val(data.calle);
            document.getElementById('edit_fila').val(data.fila);
            new bootstrap.Modal(document.getElementById('modalEditarDireccion')).show();
        })
        .catch(error => console.error('Error:', error));
}

function eliminarDireccion(id) {
    if (confirm('¿Estás seguro de eliminar esta dirección?')) {
        fetch(`/admin/direcciones/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarToast('Dirección eliminada exitosamente', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarToast(data.message || 'Error al eliminar dirección', 'danger');
                }
            })
            .catch(error => mostrarToast('Error al eliminar dirección', 'danger'));
    }
}

// ========== EVENTOS PARA LOS BOTONES DE EDICIÓN ==========
document.addEventListener('DOMContentLoaded', function () {
    // Eventos para Espacios
    document.querySelectorAll('.editar-espacio').forEach(btn => {
        btn.addEventListener('click', () => cargarEspacio(btn.dataset.id));
    });
    document.querySelectorAll('.eliminar-espacio').forEach(btn => {
        btn.addEventListener('click', () => eliminarEspacio(btn.dataset.id));
    });

    // Eventos para Cementerios
    document.querySelectorAll('.editar-cementerio').forEach(btn => {
        btn.addEventListener('click', () => cargarCementerio(btn.dataset.id));
    });
    document.querySelectorAll('.eliminar-cementerio').forEach(btn => {
        btn.addEventListener('click', () => eliminarCementerio(btn.dataset.id));
    });

    // Eventos para Dimensiones
    document.querySelectorAll('.editar-dimension').forEach(btn => {
        btn.addEventListener('click', () => cargarDimension(btn.dataset.id));
    });
    document.querySelectorAll('.eliminar-dimension').forEach(btn => {
        btn.addEventListener('click', () => eliminarDimension(btn.dataset.id));
    });

    // Eventos para Direcciones
    document.querySelectorAll('.editar-direccion').forEach(btn => {
        btn.addEventListener('click', () => cargarDireccion(btn.dataset.id));
    });
    document.querySelectorAll('.eliminar-direccion').forEach(btn => {
        btn.addEventListener('click', () => eliminarDireccion(btn.dataset.id));
    });
});