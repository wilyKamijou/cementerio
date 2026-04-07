{{-- resources/views/landing/index.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cementerio El Sepulturero Juan - Descanso y Serenidad</title>
    
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts para tipografías elegantes -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- CSS con Vite -->
    @vite(['resources/css/sepulturero-web.css'])
</head>
<body>
    <header>
        <nav>
            <a href="#" class="logo">El Sepulturero Juan<span>Cementerio y Jardines de Paz</span></a>
            <div class="menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
            <div class="nav-links">
                <a href="#inicio">Inicio</a>
                <a href="#sobre-nosotros">Sobre Nosotros</a>
                <a href="#servicios">Servicios</a>
                <a href="#espacios">Espacios</a>
                <a href="#beneficios">Beneficios</a>
                {{-- <a href="#galeria">Galería</a> --}}
                <a href="#faq">FAQ</a>
                {{-- <a href="#testimonios">Testimonios</a> --}}
                <a href="#contacto">Contacto</a>
                <a href="{{ route('login') }}">Iniciar sesion</a>
            </div>
        </nav>
    </header>

    <main>
        <!-- Inicio -->
        <section id="inicio" class="hero">
            <div class="hero-content">
                <h1>El Sepulturero Juan</h1>
                <p>Donde el descanso eterno encuentra paz y serenidad</p>
                <p style="font-size: 1.1rem; margin-bottom: 2rem;">Un lugar digno y tranquilo para honrar la memoria de sus seres queridos</p>
                <div class="hero-buttons">
                    <a href="#servicios" class="btn btn-primary">Nuestros Servicios</a>
                    <a href="#contacto" class="btn btn-secondary">Contáctenos</a>
                </div>
            </div>
        </section>

        <!-- Sobre Nosotros -->
        <section id="sobre-nosotros" class="section-light">
            <div class="container">
                <h2>Sobre Nosotros</h2>
                <div class="about-content">
                    <div class="about-text">
                        <p>Fundado hace más de 50 años por Juan Martínez, "El Sepulturero Juan" nació de un profundo respeto por la dignidad humana y el deseo de ofrecer un lugar de descanso eterno que transmitiera paz y serenidad. Lo que comenzó como un pequeño cementerio familiar, hoy es un espacio de 10 hectáreas cuidadosamente diseñado para honrar la memoria de quienes partieron.</p>
                        <p>Nuestra historia está marcada por el compromiso con las familias que confían en nosotros en sus momentos más difíciles, ofreciendo no solo un lugar de descanso, sino un espacio donde el recuerdo florece en un entorno de belleza y tranquilidad.</p>
                    </div>
                    <div class="values">
                        <div class="value-item">
                            <i class="fas fa-heart"></i>
                            <h4>Misión</h4>
                            <p>Brindar espacios dignos y servicios respetuosos para el descanso eterno</p>
                        </div>
                        <div class="value-item">
                            <i class="fas fa-eye"></i>
                            <h4>Visión</h4>
                            <p>Ser el cementerio de referencia en tranquilidad y servicio humano</p>
                        </div>
                        <div class="value-item">
                            <i class="fas fa-hand-holding-heart"></i>
                            <h4>Valores</h4>
                            <p>Respeto, empatía, profesionalismo y compromiso</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Servicios -->
        <section id="servicios" class="section-gray">
            <div class="container">
                <h2>Nuestros Servicios</h2>
                <div class="services-grid">
                    <div class="service-card">
                        <i class="fas fa-file-contract"></i>
                        <h3>Contratos Funerarios</h3>
                        <p>Planes personalizados para espacios funerarios con total transparencia y seguridad jurídica</p>
                    </div>
                    <div class="service-card">
                        <i class="fas fa-dove"></i>
                        <h3>Inhumaciones</h3>
                        <p>Servicio completo de inhumación con respeto y dignidad, coordinando todos los detalles</p>
                    </div>
                    <div class="service-card">
                        <i class="fas fa-leaf"></i>
                        <h3>Mantenimiento</h3>
                        <p>Cuidado permanente de espacios funerarios, jardinería y limpieza diaria</p>
                    </div>
                    <div class="service-card">
                        <i class="fas fa-archway"></i>
                        <h3>Venta de Nichos</h3>
                        <p>Nichos, terrenos y mausoleos en diferentes sectores del cementerio</p>
                    </div>
                    <div class="service-card">
                        <i class="fas fa-coins"></i>
                        <h3>Ventas al Contado</h3>
                        <p>Precios especiales para compras de contado con descuentos significativos</p>
                    </div>
                    <div class="service-card">
                        <i class="fas fa-credit-card"></i>
                        <h3>Planes de Pago</h3>
                        <p>Facilidades de crédito con plazos flexibles para adquirir espacios funerarios</p>
                    </div>
                    <div class="service-card">
                        <i class="fas fa-hands-helping"></i>
                        <h3>Asesoramiento</h3>
                        <p>Acompañamiento profesional en todo el proceso, resolviendo todas sus dudas</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tipos de Espacios -->
        <section id="espacios" class="section-light">
            <div class="container">
                <h2>Espacios Funerarios</h2>
                <div class="spaces-grid">
                    <div class="space-card" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1604537529428-15bcbeecfe4d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80')">
                        <h3>Nichos</h3>
                        <p>Espacios individuales en nuestros jardines verticales, rodeados de áreas verdes</p>
                    </div>
                    <div class="space-card" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1604537529428-15bcbeecfe4d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80')">
                        <h3>Mausoleos</h3>
                        <p>Estructuras privadas y familiares con diseños arquitectónicos personalizados</p>
                    </div>
                    <div class="space-card" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1604537529428-15bcbeecfe4d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80')">
                        <h3>Lotes Familiares</h3>
                        <p>Terrenos espaciosos para varias generaciones, con posibilidad de jardinería propia</p>
                    </div>
                    <div class="space-card" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1604537529428-15bcbeecfe4d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80')">
                        <h3>Espacios Individuales</h3>
                        <p>Tumbas tradicionales en áreas tranquilas con mantenimiento incluido</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Beneficios -->
        <section id="beneficios" class="section-gray">
            <div class="container">
                <h2>Beneficios de Elegirnos</h2>
                <div class="benefits-grid">
                    <div class="benefit-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <h3>Ubicación Accesible</h3>
                        <p>A solo 15 minutos del centro, con fácil acceso en transporte público y privado</p>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-shield-alt"></i>
                        <h3>Seguridad 24/7</h3>
                        <p>Vigilancia permanente y cámaras en todo el perímetro</p>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-tree"></i>
                        <h3>Mantenimiento Constante</h3>
                        <p>Jardinería y limpieza diaria en todas las áreas</p>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-peace"></i>
                        <h3>Ambiente Tranquilo</h3>
                        <p>Espacios diseñados para la meditación y el recuerdo</p>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-user-tie"></i>
                        <h3>Atención Personalizada</h3>
                        <p>Asesores dedicados para acompañarle en todo momento</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Galería 
        <section id="galeria" class="section-light">
            <div class="container">
                <h2>Galería</h2>
                <div class="gallery-grid">
                    <div class="gallery-item" style="background-image: url('https://images.unsplash.com/photo-1604537529428-15bcbeecfe4d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80')"></div>
                    <div class="gallery-item" style="background-image: url('https://images.unsplash.com/photo-1604537529428-15bcbeecfe4d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80')"></div>
                    <div class="gallery-item" style="background-image: url('https://images.unsplash.com/photo-1604537529428-15bcbeecfe4d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80')"></div>
                    <div class="gallery-item" style="background-image: url('https://images.unsplash.com/photo-1604537529428-15bcbeecfe4d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80')"></div>
                    <div class="gallery-item" style="background-image: url('https://images.unsplash.com/photo-1604537529428-15bcbeecfe4d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80')"></div>
                    <div class="gallery-item" style="background-image: url('https://images.unsplash.com/photo-1604537529428-15bcbeecfe4d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80')"></div>
                </div>
            </div>
        </section>
        -->
        <!-- Preguntas Frecuentes -->
        <section id="faq" class="section-gray">
            <div class="container">
                <h2>Preguntas Frecuentes</h2>
                <div class="faq-grid">
                    <div class="faq-item">
                        <h3>¿Cómo adquirir un espacio funerario?</h3>
                        <p>Puede contactarnos directamente, visitar nuestras instalaciones o llenar el formulario de contacto. Un asesor le guiará en todo el proceso.</p>
                    </div>
                    <div class="faq-item">
                        <h3>¿Se puede comprar al crédito?</h3>
                        <p>Sí, ofrecemos planes de financiamiento de hasta 36 meses con tasas preferenciales. Consulte con nuestros asesores.</p>
                    </div>
                    <div class="faq-item">
                        <h3>¿Qué incluye el mantenimiento?</h3>
                        <p>Incluye limpieza diaria, jardinería, riego automático, iluminación y seguridad permanente.</p>
                    </div>
                    <div class="faq-item">
                        <h3>¿Cómo se realiza una inhumación?</h3>
                        <p>Coordinamos todos los detalles con la familia, incluyendo horarios, servicio religioso si se desea, y trámites necesarios.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonios 
        <section id="testimonios" class="section-light">
            <div class="container">
                <h2>Testimonios</h2>
                <div class="testimonials-grid">
                    <div class="testimonial-card">
                        <p>"Encontrar un lugar tan hermoso para mi madre nos dio tranquilidad. El trato del personal fue excepcional en un momento tan difícil."</p>
                        <p class="testimonial-author">- Familia Rodríguez</p>
                    </div>
                    <div class="testimonial-card">
                        <p>"La paz que se respira en este lugar es única. Agradecemos el respeto y la dignidad con que tratan a nuestros seres queridos."</p>
                        <p class="testimonial-author">- María González</p>
                    </div>
                    <div class="testimonial-card">
                        <p>"Excelente atención y facilidades de pago. El mantenimiento es impecable, siempre todo limpio y cuidado."</p>
                        <p class="testimonial-author">- Familia Martínez</p>
                    </div>
                </div>
            </div>
        </section>
        -->
        <!-- Contacto -->
        <section id="contacto" class="section-gray">
            <div class="container">
                <h2>Contacto</h2>
                <div class="contact-grid">
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <p>Camino de la Paz 123, Colina del Descanso, Ciudad</p>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <p>+52 (123) 456-7890</p>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <p>info@elsepulturerojuan.com</p>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-clock"></i>
                            <p>Lunes a Viernes: 8:00 - 18:00<br>Sábados: 9:00 - 14:00<br>Domingos: Cerrado (solo visitas)</p>
                        </div>
                    </div>
                    <form class="contact-form">
                        <div class="form-group">
                            <input type="text" placeholder="Nombre completo" required>
                        </div>
                        <div class="form-group">
                            <input type="email" placeholder="Correo electrónico" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" placeholder="Teléfono">
                        </div>
                        <div class="form-group">
                            <textarea rows="5" placeholder="Mensaje" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar Mensaje</button>
                    </form>
                </div>
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.9663095343005!2d-73.98510768458426!3d40.74881797932769!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a9b30eac9f%3A0xaca05ca48ab5ac2c!2sEmpire%20State%20Building!5e0!3m2!1ses!2smx!4v1620000000000!5m2!1ses!2smx" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div>
                    <div class="footer-logo">El Sepulturero Juan</div>
                    <p>Donde el descanso eterno encuentra paz y serenidad desde hace más de 50 años.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div>
                    <h4>Enlaces Rápidos</h4>
                    <div class="footer-links">
                        <a href="#inicio">Inicio</a>
                        <a href="#sobre-nosotros">Sobre Nosotros</a>
                        <a href="#servicios">Servicios</a>
                        <a href="#espacios">Espacios</a>
                        <a href="#contacto">Contacto</a>
                    </div>
                </div>
                <div>
                    <h4>Contacto</h4>
                    <div class="footer-links">
                        <a href="tel:+521234567890">+52 (123) 456-7890</a>
                        <a href="mailto:info@elsepulturerojuan.com">info@elsepulturerojuan.com</a>
                        <p>Camino de la Paz 123<br>Colina del Descanso, Ciudad</p>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2026 Cementerio El Sepulturero Juan. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript con Vite -->
    @vite(['resources/js/sepulturero-web.js'])
</body>
</html>