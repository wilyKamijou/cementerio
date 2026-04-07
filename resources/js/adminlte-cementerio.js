// resources/js/admin-cemeterio.js

document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar
    initSidebar();
    
    // Submenús
    initSubmenus();
    
    // Active menu item
    setActiveMenu();
    
    // Tooltips y efectos
    initTooltips();
});

function initSidebar() {
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const contentWrapper = document.getElementById('contentWrapper');
    
    // Recuperar estado del sidebar
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if(isCollapsed) {
        sidebar.classList.add('collapsed');
        contentWrapper.classList.add('expanded');
    }
    
    toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
        contentWrapper.classList.toggle('expanded');
        
        // Guardar estado
        localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
    });
    
    // Cerrar sidebar en móvil al hacer clic en un enlace
    const navLinks = document.querySelectorAll('.sidebar .nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if(window.innerWidth <= 768) {
                sidebar.classList.remove('show');
            }
        });
    });
}

function initSubmenus() {
    const submenuToggles = document.querySelectorAll('.has-submenu > .nav-link');
    
    submenuToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.parentElement;
            parent.classList.toggle('open');
        });
    });
}

function setActiveMenu() {
    const currentUrl = window.location.pathname;
    const navLinks = document.querySelectorAll('.sidebar .nav-link');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if(href && href !== '#' && currentUrl.includes(href)) {
            link.classList.add('active');
            
            // Abrir submenú padre si existe
            const parentSubmenu = link.closest('.has-submenu');
            if(parentSubmenu) {
                parentSubmenu.classList.add('open');
            }
        }
    });
}

function initTooltips() {
    // Añadir efecto fade-in a las cards
    const cards = document.querySelectorAll('.stat-card, .card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('fade-in');
    });
}

// Función para confirmar acciones
function confirmAction(message, callback) {
    if(confirm(message)) {
        callback();
    }
}

// Función para mostrar loader global
function showLoader() {
    let loader = document.getElementById('globalLoader');
    if(!loader) {
        loader = document.createElement('div');
        loader.id = 'globalLoader';
        loader.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        `;
        loader.innerHTML = '<div class="loader-spinner"></div>';
        document.body.appendChild(loader);
        
        // Estilos del spinner
        const style = document.createElement('style');
        style.textContent = `
            .loader-spinner {
                width: 50px;
                height: 50px;
                border: 5px solid #f3f3f3;
                border-top: 5px solid var(--primary);
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
    }
    loader.style.display = 'flex';
}

function hideLoader() {
    const loader = document.getElementById('globalLoader');
    if(loader) {
        loader.style.display = 'none';
    }
}

// Auto-ocultar alertas después de 5 segundos
document.querySelectorAll('.alert').forEach(alert => {
    setTimeout(() => {
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 300);
    }, 5000);
});