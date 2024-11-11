<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-warning sticky-top">
    <button class="btn btn-outline-light mr-3" id="menu-toggle">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Nome do App com gradiente de cor -->
    <a class="navbar-brand ml-auto" href="/" style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 1.8rem; background: linear-gradient(to right, #FF7E5F, #FEB47B); -webkit-background-clip: text; color: transparent;">
        Group Manager
    </a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0 d-flex align-items-center">  <!-- d-flex e align-items-center para centralizar verticalmente -->
            <form action="{{ route('home') }}" method="POST" class="d-inline m-1">
                @csrf
                <!-- Alterando o estilo do botão de logout -->
                <button type="submit" class="btn btn-link nav-link text-white logout-btn">
                    Logout
                </button>
            </form>
        </ul>
    </div>
</nav>

<style>
    /* Ajusta o botão do menu de hambúrguer na navbar */
    #menu-toggle {
        transition: background-color 0.3s ease;
    }

    /* Cor de fundo padrão do botão */
    #menu-toggle {
        background-color: transparent;
        border: 1px solid #fff; /* Borda branca para manter o estilo */
    }

    /* Cor de fundo ao passar o mouse */
    #menu-toggle:hover {
        background-color: #495057; /* Cinza escuro claro, típico de hover em temas escuros */
        border-color: #495057; /* Ajuste a borda para o mesmo tom de cinza */
    }

    /* Cor de fundo quando o botão está ativo */
    #menu-toggle:active {
        background-color: #6c757d; /* Cinza um pouco mais claro para o estado ativo */
        border-color: #6c757d;
    }
</style>
