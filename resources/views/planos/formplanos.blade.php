@extends('main')
@section('titulo', 'Formulário Planos')
@section('conteudo')
<div class="row">
    @php
        if (!empty($data->id)) {
            $action = route('planos.update', $data->id);
        } else {
            $action = route('planos.store');
        }
    @endphp

    <h4>Formulário Planos</h4>
    <form action="{{ $action }}" method="post">
        @csrf
        @if (!empty($data->id))
            @method('PUT')
        @endif

        <input type="hidden" name="id" value="{{ old('id', $data->id ?? '') }}">
        <div class="col-6">
            <label for="nome_plano">Nome do Plano</label>
            <input type="text" name="nome_plano" class="form-control"
                value="{{ old('nome_plano', $data->nome_plano ?? '') }}">
        </div>
        <div class="col-6">
            <label for="preco_mensal">Preço Mensal</label>
            <input type="float" name="preco_mensal" class="form-control"
                value="{{ old('preco_mensal', $data->preco_mensal ?? '') }}">
        </div>
        <div class="col-6">
            <label for="limite_telas">Limite de Telas</label>
            <input type="number" name="limite_telas" class="form-control"
                value="{{ old('limite_telas', $data->limite_telas ?? '') }}">
        </div>
        <div class="col-6">
            <label for="resolucao_max">Resolução Máxima</label>
            <input type="float" name="resolucao" class="form-control"
                value="{{ old('resolucao_max', $data->resolucao_max ?? '') }}">
        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ url('planos') }}" class="btn btn-primary"> Voltar</a>
        </div>
    </form>
</div>
@stop