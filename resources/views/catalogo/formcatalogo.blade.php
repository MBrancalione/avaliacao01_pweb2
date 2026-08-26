@extends('main')
@section('titulo', 'Formulário Catalogo')
@section('conteudo')

    <!--se vier o id, ele fará a validação para saber se é uma edição ou uma criaçl~~ao de formulario-->
    @php
        if(!empty($dado->id)){
            $action = route('catalogo.update', $dado->id);
        } else {
            $action = route('catalogo.store');
        }
    @endphp

    <h4>Formulário Catalogo</h4>
    <form action="{{ $action }}" method="POST"><!--inserir a variável do php-->
        @csrf <!--formulario submetido faça a verificação se houver um formulário de um sistema externo, para bloquear-->


        @if(!empty($dado->id))
            @method('PUT')
        @endif

        <div class="row">
            <input type="hidden" name="id" value="{{$dado->id ?? '' }}"> <!--fazer as altrações do laragon. quando for salvar os dados do formulário após validação e mantem os dados do formulário caso algum erro-->
            <div class="col">
                <label for="titulo" class="form-label">Titulo</label>
                <input type="text" class="form-control" name="titulo" value="{{ old('titulo', $dado->titulo ?? '') }}"> <!--?? para caso o formulário não tiver dados (edição) ele carrega um espaço em brancox-->
            </div>
            <div class="col">
                <label for="sinopse" class="form-label">Sinopse</label>
                <input type="text" class="form-control" name="sinopse"
                    value="{{ old('sinopse', $dado->sinopse ?? '') }}">
            </div>
            <div class="col">
                <label class="form-label" for="genero">Genero</label>
                <input type="text" class="form-control" name="genero" value="{{ old('genero', $dado->genero ?? '') }}">
            </div>
            <div class="col">
                <label class="form-label" for="ano">Ano</label>
                <input type="text" class="form-control" name="ano" value="{{ old('ano', $dado->ano ?? '') }}">
            </div>
            <div class="col">
                <label class="form-label" for="classificacao">Classificação</label>
                <input type="text" class="form-control" name="classificacao" value="{{ old('classificacao', $dado->classificacao ?? '') }}">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-success">Salvar</button>
                <a href="{{ url('catalogo') }}" class="btn btn-primary">Voltar</a>
            </div>
        </div>
    </form>

@stop
