// resources/js/sepulturero.js

// ========== MODAL DE USUARIO ==========
document.addEventListener('DOMContentLoaded', function () {

    // Elementos del modal
    const modal = document.getElementById('userModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const closeModalOptionBtn = document.getElementById('closeModalOptionBtn');
    const editProfileBtn = document.getElementById('editProfileBtn');

    // Variable para guardar la posición del scroll
    let scrollPosition = 0;

    // IMPORTANTE: Forzar ocultar modal al cargar
    if (modal) {
        modal.style.display = 'none';
        modal.classList.remove('show');
    }

    // Función para prevenir el scroll con teclado en el fondo
    function preventKeyboardScroll(e) {
        const keys = ['ArrowUp', 'ArrowDown', 'PageUp', 'PageDown', 'Home', 'End', ' ', 'Space'];
        if (keys.includes(e.key) || e.key === ' ' || e.key === 'Space') {
            // Verificar si el modal está abierto
            if (modal && modal.style.display === 'flex') {
                // Verificar si el foco no está dentro del modal
                const isModalFocused = modal.contains(document.activeElement);

                // Si el foco está fuera del modal o es el body, prevenir scroll
                if (!isModalFocused || document.activeElement === document.body) {
                    e.preventDefault();
                    return false;
                }
            }
        }
    }

    // Función para manejar el scroll dentro del modal
    function handleModalScroll(e) {
        if (!modal || modal.style.display !== 'flex') return;

        const body = modal.querySelector('.user-modal-body');
        if (!body) return;

        const isAtTop = body.scrollTop === 0;
        const isAtBottom = body.scrollHeight - body.scrollTop === body.clientHeight;

        // Prevenir que el scroll se propague al fondo
        if ((e.key === 'ArrowUp' && isAtTop) || (e.key === 'ArrowDown' && isAtBottom)) {
            e.preventDefault();
        }
    }

    // Función para abrir modal
    function openModal() {
        if (modal) {
            // Guardar la posición actual del scroll
            scrollPosition = window.scrollY;

            // Mostrar modal
            modal.style.display = 'flex';
            modal.classList.add('show');

            // Bloquear scroll de la página de fondo
            document.body.style.overflow = 'hidden';
            document.body.style.position = 'fixed';
            document.body.style.top = `-${scrollPosition}px`;
            document.body.style.width = '100%';

            // Enfocar el modal para capturar eventos de teclado
            modal.focus();

            // Agregar event listeners para teclado
            document.addEventListener('keydown', preventKeyboardScroll);
            document.addEventListener('keydown', handleModalScroll);

            console.log('Modal abierto');
        }
    }

    // Función para cerrar modal
    function closeModal() {
        if (modal) {
            // Ocultar modal
            modal.style.display = 'none';
            modal.classList.remove('show');

            // Restaurar scroll de la página
            document.body.style.overflow = '';
            document.body.style.position = '';
            document.body.style.top = '';
            document.body.style.width = '';

            // Volver a la posición guardada
            window.scrollTo(0, scrollPosition);

            // Remover event listeners de teclado
            document.removeEventListener('keydown', preventKeyboardScroll);
            document.removeEventListener('keydown', handleModalScroll);

            console.log('Modal cerrado');
        }
    }

    // Buscar cualquier elemento que pueda abrir el modal
    const userInfoBtn = document.getElementById('userInfoBtn');
    if (userInfoBtn) {
        userInfoBtn.addEventListener('click', openModal);
        console.log('Botón userInfoBtn encontrado');
    } else {
        console.log('No se encontró el botón con ID: userInfoBtn');
        const userClickable = document.querySelector('.user-info-clickable');
        if (userClickable) {
            userClickable.addEventListener('click', openModal);
            console.log('Botón .user-info-clickable encontrado');
        } else {
            console.log('No se encontró ningún botón para abrir el modal');
            document.addEventListener('keydown', function (e) {
                if (e.key === 'F12') {
                    openModal();
                    console.log('Modal abierto con F12 (modo prueba)');
                }
            });
        }
    }

    // Cerrar modal con botón X
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }

    // Cerrar modal con botón "Volver"
    if (closeModalOptionBtn) {
        closeModalOptionBtn.addEventListener('click', closeModal);
    }

    // Cerrar modal al hacer clic fuera
    if (modal) {
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    }

    // Cerrar modal con tecla ESC
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && modal && modal.style.display === 'flex') {
            closeModal();
        }
    });

    // Redirigir a editar perfil
    if (editProfileBtn) {
        editProfileBtn.addEventListener('click', function () {
            window.location.href = '/profile';
        });
    }

    // Prevenir cierre al hacer clic dentro
    const modalContent = document.querySelector('.user-modal-content');
    if (modalContent) {
        modalContent.addEventListener('click', function (event) {
            event.stopPropagation();
        });
    }

    // Hacer que el modal sea focusable
    if (modal) {
        modal.setAttribute('tabindex', '-1');
    }

    console.log('Modal inicializado:', {
        modal: !!modal,
        closeBtn: !!closeModalBtn,
        closeOptionBtn: !!closeModalOptionBtn,
        editBtn: !!editProfileBtn
    });
});