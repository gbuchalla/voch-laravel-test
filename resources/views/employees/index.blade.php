@extends('layouts.app')

@section('content')
<div class="container custom-container">

    <!-- Exibindo mensagens de sucesso e erro -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <!-- Exibindo erros de validação -->
    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="m-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <h1 class="page-title mb-4">Lista de Colaboradores</h1>

    <!-- Filtros -->
    <form method="GET" action="{{ route('employees.index') }}" class="mb-4 custom-form">
        <div class="row">
            <div class="col-md-3 mb-3">
                <input type="text" name="name" class="form-control custom-input" placeholder="Nome" value="{{ request()->name }}">
            </div>
            <div class="col-md-3 mb-3">
                <input type="text" name="cpf" class="form-control custom-input" placeholder="CPF" value="{{ request()->cpf }}">
            </div>
            <div class="col-md-3 mb-3">
                <input type="text" name="email" class="form-control custom-input" placeholder="Email" value="{{ request()->email }}">
            </div>
            <div class="col-md-3 mb-3">
                <input type="text" name="unit" class="form-control custom-input" placeholder="Unidade" value="{{ request()->unit }}">
            </div>
            <div class="col-md-3 mb-3">
                <input type="text" name="brand" class="form-control custom-input" placeholder="Marca" value="{{ request()->brand }}">
            </div>
            <div class="col-md-3 mb-3">
                <input type="text" name="economic_group" class="form-control custom-input" placeholder="Grupo Econômico" value="{{ request()->economic_group }}">
            </div>
            <div class="col-md-3 mb-3">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
            <!-- Botão Adicionar colaborador -->
            <div class="col-md-3 mb-3 text-right">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createEmployeeModal">Adicionar Colaborador</button>
            </div>
        </div>
    </form>

    <!-- Botão Gerar Relatório -->
    <div class="mb-4">
        <a href="{{ route('employees.export') }}" class="btn btn-warning">
            <i class="fas fa-download"></i> Gerar Relatório
        </a>
    </div>

    <!-- Tabela de colaboradores -->
    <div class="table-responsive custom-table">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr class="bg-dark text-light">
                    <th class="align-middle">#</th>
                    <th class="align-middle">Nome</th>
                    <th class="align-middle">Email</th>
                    <th class="align-middle">CPF</th>
                    <th class="align-middle">Unidade</th>
                    <th class="align-middle">Bandeira</th>
                    <th class="align-middle">Grupo Econômico</th>
                    <th class="align-middle">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                <tr>
                    <td>{{ $employee->id }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ substr($employee->cpf, 0, 3) . '.' . substr($employee->cpf, 3, 3) . '.' . substr($employee->cpf, 6, 3) . '-' . substr($employee->cpf, 9, 2) }}</td>
                    <td>{{ optional($employee->unit)->fantasy_name ?? 'N/A' }}</td>
                    <td>{{ optional($employee->unit?->brand)->name ?? 'N/A' }}</td>
                    <td>{{ optional($employee->unit?->brand?->economicGroup)->name ?? 'N/A' }}</td>

                    <td>
                        <!-- Botão Editar -->
                        <button class="btn btn-secondary btn-sm custom-edit-btn" 
                            data-toggle="modal" 
                            data-target="#editEmployeeModal{{ $employee->id }}">
                            Editar
                        </button>

                        <button class="btn btn-sm btn-danger" 
                            data-toggle="modal" 
                            data-target="#modalDelete{{ $employee->id }}">
                            Deletar
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Paginação -->
    <div class="d-flex justify-content-center">
        {{ $employees->links('pagination::bootstrap-4') }}
    </div>

    

    <!-- Modal de Criação -->
    <div class="modal fade" id="createEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="createEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createEmployeeModalLabel">Criar Colaborador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form id="createEmployeeForm" action="{{ route('employees.store') }}" method="POST">
                    <div class="modal-body">                   
                        @csrf
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control custom-input" id="name" value="{{ old('name') }}" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control custom-input" id="email" value="{{ old('email') }}" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="cpf">CPF (somente números)</label>
                            <input type="text" class="form-control custom-input" id="cpf" value="{{ old('cpf') }}" name="cpf" required>
                        </div>
                        <div class="form-group">
                            <label for="unit">Unidade</label>
                            <input type="text" class="form-control custom-input" id="unit" value="{{ old('unit') }}" name="unit" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary" id="saveEmployeeBtn">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Edição -->
@foreach($employees as $employee)
<div class="modal fade" id="editEmployeeModal{{ $employee->id }}" tabindex="-1" role="dialog" aria-labelledby="editEmployeeModalLabel{{ $employee->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmployeeModalLabel{{ $employee->id }}">Editar Colaborador: {{ $employee->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name{{ $employee->id }}">Nome</label>
                        <input type="text" class="form-control" id="name{{ $employee->id }}" name="name" value="{{ old('name', $employee->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email{{ $employee->id }}">Email</label>
                        <input type="email" class="form-control" id="email{{ $employee->id }}" name="email" value="{{ old('email', $employee->email) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="cpf{{ $employee->id }}">CPF (somente números)</label>
                        <input type="text" class="form-control" id="cpf{{ $employee->id }}" name="cpf" value="{{ old('cpf', $employee->cpf) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="unit{{ $employee->id }}">Unidade</label>
                        <input type="text" class="form-control" id="unit{{ $employee->id }}" name="unit" value="{{ old('unit', optional($employee->unit)->fantasy_name) }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar alterações</button>
                </div>
            </form>
        </div>
    </div> 
</div>
<!-- Modal de Exclusão -->
<div class="modal fade" id="modalDelete{{ $employee->id }}" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel{{ $employee->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteLabel{{ $employee->id }}">Deletar Grupo Econômico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Tem certeza que deseja deletar este colaborador?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-danger">Deletar</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endforeach

</div>
@endsection


<style>
    /* Botão customizado para "Adicionar" */
    .btn-custom {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 1rem;
        color: white;
        background: linear-gradient(to right, #FF7E5F, #FEB47B); /* Gradiente similar ao navbar */
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        background: linear-gradient(to left, #FF7E5F, #FEB47B);
        cursor: pointer;
        transform: scale(1.05); /* Pequeno efeito de aumento ao passar o mouse */
    }

    /* Adicionar um botão de adicionar colaborador */
    .btn-success.custom-btn {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 1rem;
        color: white;
        background-color: #28a745; /* Verde para Adicionar */
        padding: 10px 20px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .btn-success.custom-btn:hover {
        background-color: #218838;
        cursor: pointer;
    }

    /* Estilo da tabela (facilita a leitura) */
    .table thead th, .table td {
        text-align: center;
        vertical-align: middle;
    }

    /* Adicionando a quebra de linha no email para telas pequenas */
    .table td {
        word-wrap: break-word;
        word-break: break-word;
        max-width: 200px; /* Limita a largura da célula do email */
    }

    .table thead {
        background-color: #343a40;
        color: #fff;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    .table tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }

    /* Outros estilos da tabela */
    .table-responsive {
        overflow-x: auto;
    }
</style>

