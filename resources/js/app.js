import './bootstrap';
import './adminlte-cementerio.js';
import './usuario-modal.js';
//gestionarUsuarios
import './gestionarUsuario/admin-usuarios.js';
import './gestionarUsuario/permiso-crear.js';
import './gestionarUsuario/rol-crear.js';
import './gestionarUsuario/rol-editar-permisos.js';
import './gestionarUsuario/usuario-crear.js';
import './gestionarUsuario/usuario-editar.js';
import './gestionarUsuario/empleado-crear.js'
import './gestionarUsuario/empleado-editar.js'
//gestion espacios
import './espacios/admin-espacio.js'
import './espacios/cementerio-crear.js'
import './espacios/dimension-crear.js'
import './espacios/direccion-crear.js'
import './espacios/espacio-crear.js'
import './espacios/cementerio-editar.js'
import './espacios/dimension-editar.js'
import './espacios/direccion-editar.js'
import './espacios/espacio-editar.js'
// gestion de inhumaciones
import './inhumaciones/inhumaciones-crear.js';
import './inhumaciones/mantenimientos-crear.js';
import './inhumaciones/tipo-inhumaciones-crear.js';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
