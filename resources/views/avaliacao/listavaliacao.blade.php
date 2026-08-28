@extends('main')
@section('titulo', 'Listagem de Avaliações')
@section('conteudo')
    <div class="row">
        <h3>Listagem de Avaliações</h3>
        <form action="{{ route('avaliacao.search') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-2">
                    <label for="tipo">Tipo</label>
                    <select name="tipo" class="form-select">
                        <option value="nota">Nota</option>
                        <option value="comentario">Comentário</option>
                        <option value="spoiler">Spoiler</option>
                    </select>
                </div>
                <div class="col-5">
                    <label for="valor">Valor</label>
                    <input type="text" name="valor" placeholder="Pesquisar..." class="form-control">
                </div>
                <div class="col-5 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <a href="{{ url('avaliacao/create') }}" class="btn btn-success">Novo</a>
                </div>
            </div>
        </form>
    </div>

    <div class="row mt-4">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nota</th>
                    <th scope="col">Comentário</th>
                    <th scope="col">Spoiler</th>
                    <th scope="col" colspan="2">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dados as $item)
                    <tr>
                        <th scope='row'>{{ $item->id }}</th>
                        <td>{{ $item->nota }}</td>
                        <td>{{ $item->comentario }}</td>
                        <td>{{ $item->spoiler ? 'Sim' : 'Não' }}</td>
                        <td>
                            <a class='btn btn-warning' title='Editar' href="{{ route('avaliacao.edit', $item->id) }}">Editar</a>
                        </td>
                        <td>
                            <form action="{{ route('avaliacao.destroy', $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class='btn btn-danger' title='Excluir'
                                    onclick="return confirm('Deseja realmente excluir?')">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop