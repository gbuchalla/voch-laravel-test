<div class="bg-dark border-right d-flex flex-column" id="sidebar-wrapper" style="position: fixed; top: 56px; bottom: 0; width: 250px; height: calc(100vh - 56px);">
    <div class="list-group list-group-flush">
        <!-- Início -->
        <a href="{{ Route::has('home') ? route('home') : '#' }}" class="list-group-item list-group-item-action text-white">
            <i class="fas fa-home mr-2"></i> Início
        </a>

        <!-- Separador entre Início e os outros itens -->
        <hr class="sidebar-divider">

        <!-- Colaboradores -->
        <a href="{{ Route::has('employees.index') ? route('employees.index') : '#' }}" class="list-group-item list-group-item-action text-white">
            <i class="fas fa-users mr-2"></i> Colaboradores
        </a>
        
        <!-- Unidades -->
        <a href="{{ Route::has('units.index') ? route('units.index') : '#' }}" class="list-group-item list-group-item-action text-white">
            <i class="fas fa-building mr-2"></i> Unidades
        </a>

        <!-- Bandeiras -->
        <a href="{{ Route::has('brands.index') ? route('brands.index') : '#' }}" class="list-group-item list-group-item-action text-white">
            <i class="fas fa-tag mr-2"></i> Bandeiras
        </a>
        
        <!-- Grupos Econômicos -->
        <a href="{{ Route::has('economic-groups.index') ? route('economic-groups.index') : '#' }}" style="width:max-content;" class="list-group-item list-group-item-action text-white">
            <i class="fas fa-sitemap mr-2"></i> Grupos Econômicos
        </a>

        <!-- Novo item de Auditoria -->
        <a href="{{ Route::has('audits.index') ? route('audits.index') : '#' }}" class="list-group-item list-group-item-action text-white">
            <i class="fas fa-search mr-2"></i> Auditoria
        </a>

        <!-- Separador entre os itens principais e o Logout -->
        <hr class="sidebar-divider">

        <!-- Logout -->
        <form action="{{ Route::has('logout') ? route('logout') : '#' }}" method="POST" class="mt-auto">
            @csrf
            <button type="submit" class="list-group-item list-group-item-action text-white bg-dark text-left">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </button>
        </form>
    </div>

    <!-- Informação do usuário logado (no final da sidebar) -->
    <div class="list-group-item text-white bg-dark mt-auto">
        <small>Logado como: 
            <strong>
                {{ Auth::check() ? Auth::user()->name : 'Usuário' }}
            </strong>
        </small>
    </div>
</div>

<!-- Estilos customizados -->
<style>
    #sidebar-wrapper {
        padding-top: 20px; /* Ajuste conforme necessário */
    }

    /* Separadores customizados */
    .sidebar-divider {
        border-top: 1px solid #495057; /* Linha horizontal sutil */
        margin: 10px 0;
        background-color: transparent; /* Deixa o fundo transparente para não interferir no estilo */
    }

    /* Estilo para os itens da lista */
    #sidebar-wrapper .list-group-item {
        border: none;
        border-radius: 10px;
        background-color: #343a40;
        transition: background-color 0.3s;
    }

    /* Hover no item */
    #sidebar-wrapper .list-group-item:hover {
        background-color: #495057;
    }

    /* Efeito no ícone */
    #sidebar-wrapper .list-group-item i {
        transition: transform 0.3s;
    }

    /* Efeito ao passar o mouse sobre o ícone */
    #sidebar-wrapper .list-group-item:hover i {
        transform: scale(1.05);
    }

    /* Estilo para o item ativo */
    #sidebar-wrapper .list-group-item.active {
        background-color: #6c757d;
        color: #fff !important;
    }

    /* Estilo para o item de logout */
    #sidebar-wrapper .list-group-item:last-child {
        background-color: #343a40;
        text-align: center;
    }

    /* Estilo para a informação do usuário no final da sidebar */
    #sidebar-wrapper .list-group-item:last-child {
        background-color: #343a40;
        text-align: center;
    }
</style>
