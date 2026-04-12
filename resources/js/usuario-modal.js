// resources/js/sepulturero.js - Modal de usuario SIMPLIFICADO

document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('userModal');
    const userInfoBtn = document.getElementById('userInfoBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const editProfileBtn = document.getElementById('editProfileBtn');

    // Abrir modal
    if (userInfoBtn && modal) {
        userInfoBtn.addEventListener('click', function (e) {
            e.preventDefault();
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
    }

    // Cerrar modal (X)
    if (closeModalBtn && modal) {
        closeModalBtn.addEventListener('click', function () {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        });
    }

    // Cerrar al hacer clic fuera del contenido
    if (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }
        });
    }

    // Cerrar con tecla ESC
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal && modal.style.display === 'flex') {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    });

    // Editar perfil
    if (editProfileBtn) {
        editProfileBtn.addEventListener('click', function () {
            window.location.href = '/profile';
        });
    }

    console.log('Modal de usuario inicializado correctamente');
});