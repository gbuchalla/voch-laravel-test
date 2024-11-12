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
        <h1>Unidades</h1>
        <button class="btn btn-success" data-toggle="modal" data-target="#modalCreate">Adicionar Unidade</button>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th class="align-middle">ID</th>
                <th class="align-middle">Nome Fantasia</th>
                <th class="align-middle">Nome Corporativo</th>
                <th class="align-middle">CNPJ</th>
                <th class="align-middle">Bandeira</th> <!-- Coluna de Bandeira -->
                <th class="align-middle">Grupo Econômico</th> <!-- Coluna de Grupo Econômico -->
                <th class="align-middle">Data de Criação</th>
                <th class="align-middle">Última Atualização</th>
                <th class="align-middle">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($units as $unit)
            <tr>
                <td>{{ $unit->id }}</td>
                <td>{{ $unit->fantasy_name }}</td>
                <td>{{ $unit->corporate_name }}</td>
                <td>{{ substr($unit->cnpj, 0, 2) . '.' . substr($unit->cnpj, 2, 3) . '.' . substr($unit->cnpj, 5, 3) . '/' . substr($unit->cnpj, 8, 4) . '-' . substr($unit->cnpj, 12, 2) }}</td>
                <td>{{ $unit->brand ? $unit->brand->name : 'Sem Bandeira' }}</td> <!-- Exibe a bandeira -->
                <td>
                    @if($unit->brand && $unit->brand->economicGroup)
                        {{ $unit->brand->economicGroup->name }} <!-- Exibe o grupo econômico da marca -->
                    @else
                        Sem Grupo Econômico
                    @endif
                </td>
                <td>{{ $unit->created_at }}</td>
                <td>{{ $unit->updated_at }}</td>
                <td class="actions-column">
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modalEdit{{ $unit->id }}">Editar</button>
                        <button class="btn btn-sm btn-danger ml-1" data-toggle="modal" data-target="#modalDelete{{ $unit->id }}">Deletar</button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginação -->
    <div class="d-flex justify-content-center">
        {{ $units->links('pagination::bootstrap-4') }}
    </div>
</div>


<!-- Modal de Criação -->
<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreateLabel">Adicionar Unidade</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('units.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fantasy_name">Nome Fantasia</label>
                        <input type="text" class="form-control" id="fantasy_name" name="fantasy_name" value="{{ old('fantasy_name') }}" required>
                        @error('fantasy_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="corporate_name">Razão Social</label>
                        <input type="text" class="form-control" id="corporate_name" name="corporate_name" value="{{ old('corporate_name') }}" required>
                        @error('corporate_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="cnpj">CNPJ</label>
                        <input type="text" class="form-control" id="cnpj" name="cnpj" value="{{ old('cnpj') }}" required>
                        @error('cnpj')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Campo de entrada de texto para Bandeira -->
                    <div class="form-group">
                        <label for="brand_name">Bandeira</label>
                        <input type="text" class="form-control" id="brand_name" name="brand_name" value="{{ old('brand_name') }}" required>
                        @error('brand_name')
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
@foreach($units as $unit)
<div class="modal fade" id="modalEdit{{ $unit->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel{{ $unit->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel{{ $unit->id }}">Editar Unidade</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('units.update', $unit->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fantasy_name">Nome Fantasia</label>
                        <input type="text" class="form-control" id="fantasy_name" name="fantasy_name" value="{{ old('fantasy_name', $unit->fantasy_name) }}" required>
                        @error('fantasy_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="corporate_name">Razão Social</label>
                        <input type="text" class="form-control" id="corporate_name" name="corporate_name" value="{{ old('corporate_name', $unit->corporate_name) }}" required>
                        @error('corporate_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="cnpj">CNPJ</label>
                        <input type="text" class="form-control" id="cnpj" name="cnpj" value="{{ old('cnpj', $unit->cnpj) }}" required>
                        @error('cnpj')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Campo de entrada de texto para Bandeira -->
                    <div class="form-group">
                        <label for="brand_name">Bandeira</label>
                        <input type="text" class="form-control" id="brand_name" name="brand_name" value="{{ old('brand_name', $unit->brand ? $unit->brand->name : '') }}" required>
                        @error('brand_name')
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
@endforeach



<!-- Modal de Exclusão -->
<div class="modal fade" id="modalDelete{{ $unit->id }}" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel{{ $unit->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteLabel{{ $unit->id }}">Deletar Unidade</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('units.destroy', $unit->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Tem certeza que deseja deletar esta unidade?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-danger">Deletar</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

<style>
/* Botões e Tabela */
.btn-custom, .btn-edit, .btn-delete {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 1rem;
    padding: 8px 15px;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.btn-custom {
    background: linear-gradient(to right, #FF7E5F, #FEB47B);
    border: none;
    color: white;
}

.btn-custom:hover {
    background: linear-gradient(to left, #FF7E5F, #FEB47B);
    cursor: pointer;
    transform: scale(1.05);
}

.btn-edit {
    background-color: #6c757d;
    color: white;
}

.btn-edit:hover {
    background-color: #5a6268;
    cursor: pointer;
    transform: scale(1.05);
}

.btn-delete {
    background-color: #dc3545;
    color: white;
}

.btn-delete:hover {
    background-color: #c82333;
    cursor: pointer;
    transform: scale(1.05);
}

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

/* Estilo para os modais */
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
