// resources/js/sepulturero.js

// Sistema de Gestión Funeraria
const SistemaGestion = {
    contratos: [],
    inhumaciones: [],
    mantenimientos: [],
    ventas: [],

    // Métodos para interactuar con el sistema
    nuevoContrato: function(datos) {
        console.log('Creando nuevo contrato:', datos);
        this.contratos.push(datos);
        this.actualizarInterfaz();
        return this.contratos;
    },

    registrarInhumacion: function(datos) {
        console.log('Registrando inhumación:', datos);
        this.inhumaciones.push(datos);
        this.actualizarInterfaz();
        return this.inhumaciones;
    },

    solicitarMantenimiento: function(datos) {
        console.log('Solicitando mantenimiento:', datos);
        this.mantenimientos.push(datos);
        this.actualizarInterfaz();
        return this.mantenimientos;
    },

    registrarVenta: function(datos, tipo) {
        console.log(`Registrando venta ${tipo}:`, datos);
        this.ventas.push({...datos, tipo});
        this.actualizarInterfaz();
        return this.ventas;
    },

    actualizarInterfaz: function() {
        console.log('Interfaz actualizada');
        // Aquí iría la lógica para actualizar la UI con datos reales
    }
};

// Funciones de UI
function initTabs() {
    const tabs = document.querySelectorAll('.tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(c => c.classList.remove('active'));
            const target = document.getElementById(this.dataset.tab);
            if (target) target.classList.add('active');
        });
    });
}

function initActionButtons() {
    const actionBtns = document.querySelectorAll('.action-btn');
    actionBtns.forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
        });
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
        
        // Acciones específicas según el botón
        btn.addEventListener('click', function(e) {
            const texto = this.querySelector('span')?.innerText || this.innerText;
            if (texto.includes('Nuevo Contrato')) {
                alert('Funcionalidad: Crear nuevo contrato');
            } else if (texto.includes('Registrar Inhumación')) {
                alert('Funcionalidad: Registrar inhumación');
            } else if (texto.includes('Solicitar Mantenimiento')) {
                alert('Funcionalidad: Solicitar mantenimiento');
            } else if (texto.includes('Venta a Crédito')) {
                alert('Funcionalidad: Registrar venta a crédito');
            } else if (texto.includes('Generar Reporte')) {
                alert('Funcionalidad: Generar reporte');
            } else if (texto.includes('Buscar Difunto')) {
                alert('Funcionalidad: Buscar difunto');
            }
        });
    });
}

function initForms() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Funcionalidad en desarrollo');
        });
    });
}

function initButtons() {
    const buttons = document.querySelectorAll('button:not(.action-btn)');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            if(!this.classList.contains('action-btn')) {
                alert('Funcionalidad en desarrollo: ' + this.innerText);
            }
        });
    });
}

function initSearch() {
    const searchBtn = document.querySelector('.search-btn');
    if (searchBtn) {
        searchBtn.addEventListener('click', function() {
            const searchType = document.getElementById('searchType')?.value;
            const searchTerm = document.getElementById('searchTerm')?.value;
            if (searchTerm) {
                alert(`Buscando en ${searchType}: "${searchTerm}"`);
            } else {
                alert('Ingrese un término de búsqueda');
            }
        });
    }
}

function initQuickRegister() {
    const quickRegisterBtn = document.getElementById('quickRegisterBtn');
    const quickRegisterType = document.getElementById('quickRegisterType');
    
    if (quickRegisterBtn && quickRegisterType) {
        quickRegisterBtn.addEventListener('click', function() {
            const tipo = quickRegisterType.options[quickRegisterType.selectedIndex]?.text;
            if (tipo && tipo !== 'Seleccionar tipo de registro') {
                alert(`Funcionalidad en desarrollo: ${tipo}`);
            } else {
                alert('Seleccione un tipo de registro');
            }
        });
    }
}

function updateStats() {
    console.log('Actualizando estadísticas...');
    // Aquí iría la lógica para actualizar datos via API
}

// Inicializar todo cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    initTabs();
    initActionButtons();
    initForms();
    initButtons();
    initSearch();
    initQuickRegister();
    
    // Intervalo de actualización cada 30 segundos
    setInterval(updateStats, 30000);
});

// Exportar para uso global
window.SistemaGestion = SistemaGestion;