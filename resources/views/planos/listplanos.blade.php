@extends('main')
@section('titulo', 'Listagem de planoss')
@section('conteudo')
    <div class="row">

        <h3>Listagem de planoss</h3>
        <form action="{{ route('planos.search') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-2">
                    <label for="nome">Tipo</label>
                    <select name="tipo" class="form-select">
                        <option value="nome_planos">Nome do planos</option>
                        <option value="preco_mensal">Preço Mensal</option>
                        <option value="limite_telas">Limite de Telas</option>
                        <option value="resolucao_max">Resolução Máxima</option>
                    </select>
                </div>
                <div class="col-5">
                    <label for="valor">Valor</label>
                    <input type="text" name="valor" placeholder="Pesquisar..." class="form-control">
                </div>
                <div class="col-5">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <a href="{{ url('planos/create') }}" class="btn btn-success"> Novo</a>
                </div>
            </div>
        </form>

    </div>


    <div class="row mt-4">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome do planos</th>
                    <th scope="col">Preço Mensal</th>
                    <th scope="col">Limite de Telas</th>
                    <th scope="col">Resolução Máxima</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dado as $item)
                    <tr>
                        <th scope='row'>{{ $item->id }}</th>
                        <td>{{ $item->nome_planos}}</td>
                        <td>{{ $item->preco_mensal}}</td>
                        <td>{{ $item->limite_telas }}</td>
                        <td>{{ $item->resolucao_max }}</td>
                        <td>
                            <a class='btn btn-warning' title='Editar' href="{{ route('planos.edit', $item->id) }}">Editar</a>
                        </td>
                        <td>
                            <form action="{{ route('planos.destroy', $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class='btn btn-danger' title='Exclur'
                                    onclick='return confirm(\"Deseja Excluir?\")'>Deletar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop