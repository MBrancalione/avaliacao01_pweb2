@extends('main')
@section('titulo', 'Formulário de Avaliacao')
@section('conteudo')
<div class="row">
    @php
        if (!empty($data->id)) {
            $action = route('avaliacao.update', $data->id);
        } else {
            $action = route('avaliacao.store');
        }
    @endphp

    <h4>Formulário Avaliação</h4>
    <form action="{{ $action }}" method="post">
        @csrf
        @if (!empty($data->id))
            @method('PUT')
        @endif

        <input type="hidden" name="id" value="{{ old('id', $data->id ?? '') }}">
        <div class="col-6">
            <label for="nota">Nota</label>
            <input type="text" name="nota" class="form-control" value="{{ old('nota', $data->nota ?? '') }}">
            <option value="" style="color: #000;">Escolha uma nota...</option>

        </div>
        <div class="col-6">
            <label for="preco_mensal">Comentario</label>
            <input type="text" name="comentario" class="form-control"
                value="{{ old('comentario', $data->comentario ?? '') }}">
        </div>
        <div class="col-6">
            <label for="spoiler">Spoiler</label>
            <input type="bool" name="spoiler" class="form-control"
                value="{{ old('spoiler', $data->spoiler ?? '') }}">

        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ url('avaliacao') }}" class="btn btn-primary"> Voltar</a>
        </div>
    </form>
</div>
@stop