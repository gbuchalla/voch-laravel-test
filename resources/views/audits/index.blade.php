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
        <h1>Auditoria</h1>
        <!-- Placeholder para o botão de download do relatório -->
        {{-- <button class="btn btn-info" disabled>Baixar Relatório de Auditoria</button> --}}
    </div>

    <table class="table">
        <thead>
            <tr>
                <th class="align-middle">ID</th>
                <th class="align-middle">Entidade</th>
                <th class="align-middle">Ação</th>
                <th class="align-middle">Usuário</th>
                <th class="align-middle">Data da Alteração</th>
                <th class="align-middle">Detalhes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($audits as $audit)
            <tr>
                <td>{{ $audit->id }}</td>
                <td>{{ Str::substr($audit->auditable_type, 11) }}</td>
                <td>{{ ucwords($audit->action) }}</td>
                <td>{{ $audit->user ? $audit->user->name : 'Desconhecido' }}</td>
                <td>{{ $audit->created_at->format('d/m/Y H:i:s') }}</td>
                <td class="actions-column">
                    <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modalDetails{{ $audit->id }}">Ver Detalhes</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginação -->
    <div class="d-flex justify-content-center">
        {{ $audits->links('pagination::bootstrap-4') }}
    </div>
</div>

<!-- Modal de Detalhes -->
@foreach($audits as $audit)
<div class="modal fade" id="modalDetails{{ $audit->id }}" tabindex="-1" role="dialog" aria-labelledby="modalDetailsLabel{{ $audit->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailsLabel{{ $audit->id }}">Detalhes da Auditoria (ID: {{ $audit->id }})</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Entidade:</strong> {{ Str::substr($audit->auditable_type, 11) }}</p>
                <p><strong>Ação:</strong> {{ ucwords($audit->action) }}</p> 
                <p><strong>Usuário:</strong> {{ $audit->user_id ? $audit->user->name : 'Desconhecido' }}</p>
                <p><strong>Data da Alteração:</strong> {{ $audit->created_at->format('d/m/Y H:i:s') }}</p>
                <p><strong>Detalhes:</strong></p>
                <!-- Exibe o conteúdo da coluna 'changes' -->
                <pre>{{ json_encode($audit->changes, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) }}</pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
@endforeach


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

.btn-info {
    background-color: #17a2b8;
    color: white;
}

.btn-info:hover {
    background-color: #138496;
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
