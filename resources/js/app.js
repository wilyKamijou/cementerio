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


import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
