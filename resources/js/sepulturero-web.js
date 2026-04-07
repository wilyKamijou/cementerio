// resources/js/sepulturero-landing.js

// Esperar a que el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    
    // Menú móvil - toggle
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    
    if (menuToggle && navLinks) {
        menuToggle.addEventListener('click', function() {
            navLinks.classList.toggle('active');
        });
    }

    // Cerrar menú al hacer clic en un enlace
    const navLinksItems = document.querySelectorAll('.nav-links a');
    navLinksItems.forEach(link => {
        link.addEventListener('click', function() {
            if (navLinks) {
                navLinks.classList.remove('active');
            }
        });
    });

    // Smooth scroll para enlaces internos
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Galería - efecto lightbox (opcional)
    const galleryItems = document.querySelectorAll('.gallery-item');
    galleryItems.forEach(item => {
        item.addEventListener('click', function() {
            const bgImage = this.style.backgroundImage;
            console.log('Abrir lightbox con:', bgImage);
            // Aquí puedes implementar un lightbox si lo deseas
            alert('Galería - Imagen ampliada (funcionalidad en desarrollo)');
        });
    });

    // Formulario de contacto - validación básica
    const contactForm = document.querySelector('.contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const nombre = this.querySelector('input[placeholder="Nombre completo"]');
            const email = this.querySelector('input[placeholder="Correo electrónico"]');
            const mensaje = this.querySelector('textarea[placeholder="Mensaje"]');
            
            if (nombre && nombre.value.trim() === '') {
                alert('Por favor, ingrese su nombre completo');
                nombre.focus();
                return;
            }
            
            if (email && email.value.trim() === '') {
                alert('Por favor, ingrese su correo electrónico');
                email.focus();
                return;
            }
            
            if (email && !isValidEmail(email.value)) {
                alert('Por favor, ingrese un correo electrónico válido');
                email.focus();
                return;
            }
            
            if (mensaje && mensaje.value.trim() === '') {
                alert('Por favor, escriba un mensaje');
                mensaje.focus();
                return;
            }
            
            alert('Mensaje enviado exitosamente. Nos pondremos en contacto pronto.');
            this.reset();
        });
    }

    // Función para validar email
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Efecto de aparición al hacer scroll (opcional)
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Aplicar efecto a secciones
    const sections = document.querySelectorAll('section');
    sections.forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(section);
    });
});