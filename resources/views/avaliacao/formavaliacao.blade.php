@extends('main')
@section('titulo', 'Formulário de Avaliação')
@section('conteudo')

<div class="flex justify-center">
    <div class="p-6 bg-white shadow sm:rounded-lg w-full max-w-2xl">
        <h4 class="text-lg font-medium text-gray-900 mb-6 text-center">Formulário Avaliação</h4>

        <form action="{{ !empty($dados->id) ? route('avaliacao.update', $dados->id) : route('avaliacao.store') }}"
            method="post" class="space-y-4">
            @csrf
            @if (!empty($dados->id))
                @method('PUT')
            @endif

            <input type="hidden" name="id" value="{{ old('id', $dados->id ?? '') }}"> <!--id av-->

<div>
    <label for="filme_id" class="block font-medium text-sm text-gray-700 mb-1">Filme</label>
    <select name="filme_id" id="filme_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
        <option value="">Selecione um filme</option>
        @foreach($filmes as $f)
            <option value="{{ $f->id }}" {{ old('filme_id', $dados->filme_id ?? $filme_id ?? '') == $f->id ? 'selected' : '' }}>{{ $f->titulo }}</option>
        @endforeach
    </select>
</div>
            <div>
                <label for="nota" class="block font-medium text-sm text-gray-700 mb-1">Nota</label>
                <input type="number" min="0" max="5" name="nota"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                    value="{{ old('nota', $dados->nota ?? '') }}">
            </div>

            <div>
                <label for="comentario" class="block font-medium text-sm text-gray-700 mb-1">Comentário</label>
                <input type="text" name="comentario"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                    value="{{ old('comentario', $dados->comentario ?? '') }}">
            </div>

            <div>
                <label for="spoiler" class="block font-medium text-sm text-gray-700 mb-1">Spoiler</label>
                <select name="spoiler"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                    <option value="0" {{ old('spoiler', $dados->spoiler ?? '') == 0 ? 'selected' : '' }}>Não</option>
                    <option value="1" {{ old('spoiler', $dados->spoiler ?? '') == 1 ? 'selected' : '' }}>Sim</option>
                </select>
            </div>

            <div class="flex items-center justify-center gap-3 pt-4">
                <button type="submit" style="background-color: #16a34a; color: #ffffff;"
                    class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                    {{ !empty($dados->id) ? 'Atualizar' : 'Salvar' }}
                </button>
                <a href="{{ url('avaliacao') }}" style="background-color: #2563eb; color: #ffffff;"
                    class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                    Voltar
                </a>
            </div>
        </form>
    </div>
</div>

@stop