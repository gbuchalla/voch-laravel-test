@extends('layouts.app')

@section('content')
<div class="container">
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

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Grupos Econômicos</h1>
        <button class="btn btn-success" data-toggle="modal" data-target="#modalCreate">Adicionar Grupo Econômico</button>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Data de Criação</th>
                <th>Última Atualização</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($economicGroups as $economicGroup)
            <tr>
                <td>{{ $economicGroup->id }}</td>
                <td>{{ $economicGroup->name }}</td>
                <td>{{ $economicGroup->created_at }}</td>
                <td>{{ $economicGroup->updated_at }}</td>
                <td>
                    <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modalEdit{{ $economicGroup->id }}">Editar</button>
                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalDelete{{ $economicGroup->id }}">Deletar</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginação -->
    <div class="d-flex justify-content-center">
        {{ $economicGroups->links('pagination::bootstrap-4') }}
    </div>
</div>

<!-- Modal de Criação -->
<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreateLabel">Adicionar Grupo Econômico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('economic-groups.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Edição -->
@foreach($economicGroups as $economicGroup)
<div class="modal fade" id="modalEdit{{ $economicGroup->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel{{ $economicGroup->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel{{ $economicGroup->id }}">Editar Grupo Econômico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('economic-groups.update', $economicGroup->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $economicGroup->name) }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
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
<div class="modal fade" id="modalDelete{{ $economicGroup->id }}" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel{{ $economicGroup->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteLabel{{ $economicGroup->id }}">Deletar Grupo Econômico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('economic-groups.destroy', $economicGroup->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Tem certeza que deseja deletar este grupo econômico?</p>
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

    /* Botão "Editar" */
    .btn-edit {
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        font-size: 1rem;
        color: white;
        background-color: #6c757d;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .btn-edit:hover {
        background-color: #5a6268;
        cursor: pointer;
        transform: scale(1.05);
    }

    /* Botão "Deletar" */
    .btn-delete {
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        font-size: 1rem;
        color: white;
        background-color: #dc3545;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .btn-delete:hover {
        background-color: #c82333;
        cursor: pointer;
        transform: scale(1.05);
    }

    /* Estilo da tabela (facilita a leitura) */
    .table th, .table td {
        text-align: center;
        vertical-align: middle;
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

    /* Efeito para os modais */
    .modal-content {
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Botões do modal */
    .modal-footer .btn {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .modal-footer .btn:hover {
        transform: scale(1.05);
    }

    /* Estilos para a paginação */
    .pagination .page-link {
        color: #495057;
        border-color: #dee2e6;
    }

    .pagination .page-item.active .page-link {
        background-color: #FF7E5F;
        border-color: #FF7E5F;
        color: white;
    }



</style>