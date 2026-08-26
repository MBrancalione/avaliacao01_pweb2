@extends('main')
@section('titulo', 'Listagem de Catalogo')
@section('conteudo')
<div class="row">

  <h3>Listagem de Catalogos</h3>

  <!--busca de dados por valor específico-->
    <form action="{{route('catalogo.search')}}" method="post">
      <div class="row">
        <div class="col-6">
            <label for="nome">Tipo</label>
            <select name="tipo" class="form-selection">
                <option value="titulo">Título</option>
                <option value="genero">Genero</option>                
                <option value="classificacao">Classificação</option>
                <option value="ano">Ano</option>
            </select>
        </div>
        <div class="col-6">
            <label for="email">Valor</label>
            <input type="text" name="valor" placeholder="Valor da busca" class="form-control" value="{{ request('valor') }}">        </div>
        <div class="col">
          <button type="submit"  class="btn btn-primary">Buscar</button>
          <a href="{{url('catalogo/create')}}" class="btn btn-success"> Novo</a> <!--linkagem de páginas Laravel (substituir tudo que estava como php)-->
        </div>
      </div>
    </form>
</div>


<div class="row">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Título</th>
                <th scope="col">Gênero</th>
                <th scope="col">Classificação</th>
                <th scope="col">Ano</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <!--<php tem sua linguagem própria-->
            @foreach ($dados as $item)
                <tr>
                <th scope='row'>{{$item->id}}</th>
                <td>{{$item->titulo}}</td>
                <td>{{$item->genero}}</td>
                <td>{{$item->classificacao}}</td>
                <td>{{$item->ano}}</td>
<!--botões de ação para chamar função de edit e destroy-->
                <td><a
                    class='btn btn-warning' title='Editar'
                    href="{{route('catalogo.edit', $item->id)}}">Editar</a></td> <!--passa o id como parâmetro-->
                <td>
                    <form action="{{route('catalogo.destroy', $item->id)}}" method="POST"> <!--pq precisa ser um form?-->
                        @csrf
                        @method('DELETE')
                        <button type="submit" class='bnt bnt-danger' title='Excluir'
                            onclick='return confim("\deseja excluir?")'>Deletar</button>
                    </form>
                </td>
            </tr>;
            @endforeach
        </tbody>
    </table>
</div>


@stop
