<!-- MODAL DE USUARIO -->


<div id="userModal" class="user-modal">
    <div class="user-modal-content">
        <div class="user-modal-header">
            <span class="close-modal" id="closeModalBtn">&times;</span>
            <div class="user-modal-avatar" id="modalAvatar">
                {{ substr(Auth::user()->name ?? 'AJ', 0, 2) }}
            </div>
            <h3 id="modalUserName">{{ Auth::user()->name ?? 'Administrador' }}</h3>
            <p id="modalUserRole">{{ Auth::user()->rol ?? 'Administrador' }}</p>
        </div>

        <div class="user-modal-body">
            <div class="user-info-item">
                <i class="fas fa-envelope"></i>
                <span class="label">Correo electrónico:</span>
                <span class="value" id="modalUserEmail">{{ Auth::user()->email ?? 'admin@sepulturero.com' }}</span>
            </div>
            <div class="user-info-item">
                <i class="fas fa-calendar-alt"></i>
                <span class="label">Miembro desde:</span>
                <span class="value" id="modalUserCreated">
                    {{ Auth::user()->created_at ? Auth::user()->created_at->format('d/m/Y') : '01/01/2024' }}
                </span>
            </div>
            <div class="user-info-item">
                <i class="fas fa-id-badge"></i>
                <span class="label">ID de usuario:</span>
                <span class="value" id="modalUserId">{{ Auth::user()->id ?? '1' }}</span>
            </div>
        </div>

        <div class="user-modal-options">
            <button class="modal-option-btn btn-back" id="closeModalOptionBtn">
                <i class="fas fa-arrow-left"></i>
                Volver
            </button>
            <button class="modal-option-btn btn-edit" id="editProfileBtn">
                <i class="fas fa-user-edit"></i>
                Editar datos personales
            </button>
            <form method="POST" action="{{ route('logout') }}" id="logoutForm" style="width: 100%; margin: 0;">
                @csrf
                <button type="submit" class="modal-option-btn btn-logout" style="width: 100%;">
                    <i class="fas fa-sign-out-alt"></i>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</div>
