@extends('main')
@section('titulo', 'Formulário de Avaliação')
@section('conteudo')
<div class="row">
    <h4>Formulário Avaliação</h4>

    <form action="{{ !empty($dado->id) ? route('avaliacao.update', $dado->id) : route('avaliacao.store') }}" method="post">
        @csrf
        @if (!empty($dado->id))
            @method('PUT')
        @endif

        <input type="hidden" name="id" value="{{ old('id', $dado->id ?? '') }}"> <!--id av-->

        <input type="hidden" name="filme_id" value="{{ old('catalogo_id', $dado->catalogo_id ?? $catalogo->id ?? '') }}">

        <div class="col-6 mb-2">
            <label for="nota">Nota</label>
            <input type="number" min="0" max="10" name="nota" class="form-control" value="{{ old('nota', $dado->nota ?? '') }}">
        </div>

        <div class="col-6 mb-2">
            <label for="comentario">Comentário</label>
            <input type="text" name="comentario" class="form-control" value="{{ old('comentario', $dado->comentario ?? '') }}">
        </div>

        <div class="col-6 mb-2">
            <label for="spoiler">Spoiler</label>
            <select name="spoiler" class="form-select">
                <option value="0" {{ old('spoiler', $dado->spoiler ?? '') == 0 ? 'selected' : '' }}>Não</option>
                <option value="1" {{ old('spoiler', $dado->spoiler ?? '') == 1 ? 'selected' : '' }}>Sim</option>
            </select>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-success">
                {{ !empty($dado->id) ? 'Atualizar' : 'Salvar' }}
            </button>
            <a href="{{ url('avaliacao') }}" class="btn btn-primary">Voltar</a>
        </div>
    </form>
</div>
@stop