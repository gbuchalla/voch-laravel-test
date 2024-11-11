@extends('layouts.app')

@section('title', 'Página Inicial')

@section('content')
    <div class="container py-5">
        <div class="row">
            <!-- Saudação -->
            <div class="col-12 col-md-12 mb-5">
                <div class="card shadow-lg custom-card-saudacao">
                    <div class="card-body">
                        <h2 class="text-primary fw-normal">Bem-vindo(a),
                            {{ Auth::check() ? Auth::user()->name : 'usuário!' }} 
                        </h2>
                        <p class="lead text-muted">Organize e gerencie todos os seus dados de forma simples e eficaz.</p>
                        <p class="text-muted">Aqui você pode acompanhar todos os grupos econômicos, bandeiras, unidades e colaboradores da sua organização.</p>
                    </div>
                </div>
            </div>

            <!-- Painéis de Estatísticas -->
            <div class="col-12 col-md-12">
                <div class="row">
                    <!-- Grupo Econômico -->
                    <div class="col-12 col-md-6 mb-4">
                        <div class="card custom-card custom-card-economico">
                            <div class="card-body">
                                <h5 class="card-title fw-normal">Grupos Econômicos</h5>
                                <p class="card-text">
                                    Total: {{ $totalEconomicGroups }}<br>
                                    Crescimento neste mês: {{ $growthEconomicGroups }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Bandeiras -->
                    <div class="col-12 col-md-6 mb-4">
                        <div class="card custom-card custom-card-bandeira">
                            <div class="card-body">
                                <h5 class="card-title fw-normal">Bandeiras</h5>
                                <p class="card-text">
                                    Total: {{ $totalBrands }}<br>
                                    Crescimento neste mês: {{ $growthBrands }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Unidades -->
                    <div class="col-12 col-md-6 mb-4">
                        <div class="card custom-card custom-card-unidade">
                            <div class="card-body">
                                <h5 class="card-title fw-normal">Unidades</h5>
                                <p class="card-text">
                                    Total: {{ $totalUnits }}<br>
                                    Crescimento neste mês: {{ $growthUnits }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Colaboradores -->
                    <div class="col-12 col-md-6 mb-4">
                        <div class="card custom-card custom-card-colaborador">
                            <div class="card-body">
                                <h5 class="card-title fw-normal">Colaboradores</h5>
                                <p class="card-text">
                                    Total: {{ $totalEmployees }}<br>
                                    Crescimento neste mês: {{ $growthEmployees }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


<style>
    /* Estilos gerais para os cards */
    .custom-card {
        border-radius: 15px; /* Borda arredondada */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .custom-card:hover {
        transform: translateY(-5px); /* Efeito de levitação */
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15); /* Sombra mais pronunciada */
    }

    /* Estilos personalizados para os cards de cada seção */
    
    /* Grupo Econômico */
    .custom-card-economico .card-body {
        background-color: #207491 !important; /* Azul médio */
        color: white;
    }

    .custom-card-economico .card-body .card-title {
        font-weight: 500; /* Peso da fonte atenuado */
    }

    /* Bandeiras */
    .custom-card-bandeira .card-body {
        background-color: #519179 !important; /* Verde suave */
        color: white;
    }

    .custom-card-bandeira .card-body .card-title {
        font-weight: 500; /* Peso da fonte atenuado */
    }

    /* Unidades */
    .custom-card-unidade .card-body {
        background-color: #ff9b4f !important; /* Laranja suave */
        color: white;
    }

    .custom-card-unidade .card-body .card-title {
        font-weight: 500; /* Peso da fonte atenuado */
    }

    /* Colaboradores */
    .custom-card-colaborador .card-body {
        background-color: #f7ac3b !important; /* Roxo escuro */
        color: white;
    }

    .custom-card-colaborador .card-body .card-title {
        font-weight: 500; /* Peso da fonte atenuado */
    }

    /* Personalização para o card de Saudação */
    .custom-card-saudacao .card-body {
        background-color: #F4F6F7 !important; /* Fundo neutro claro */
        padding: 30px;
    }

    .custom-card-saudacao .card-body h2 {
        font-size: 2rem;
        color: #34495E; /* Cor de texto suave */
    }

    .custom-card-saudacao .card-body p {
        font-size: 1rem;
        color: #7F8C8D;
    }

    /* Ajuste para textos em cards de estatísticas */
    .custom-card .card-text {
        font-size: 1.2rem;
    }
</style>

