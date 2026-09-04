@extends('main')
@section('titulo', 'Listagem de Usuários')
@section('conteudo')
    <div class="row">

        <h3>Listagem de Usuários</h3>
        <form action="{{ route('users.search') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-2">
                    <label for="tipo">Tipo</label>
                    <select name="tipo" class="form-select">
                        <option value="name">Nome</option>
                        <option value="email">E-mail</option>
                    </select>
                </div>
                <div class="col-5">
                    <label for="valor">Valor</label>
                    <input type="text" name="valor" placeholder="Pesquisar..." class="form-control">
                </div>
            </div>
        </form>

    </div>

    <div class="row mt-4">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Estado da Assinatura</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dados as $item)
                    <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <!-- Exibe o nome do estado cadastrado em vez do ID -->
                        <td>{{ $item->assinaturaEstado->nome ?? 'Estado da Assinatura Indefinido' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop