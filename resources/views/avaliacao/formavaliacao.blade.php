@extends('main')
@section('titulo', 'Formulário de Avaliação')
@section('conteudo')

<div class="flex justify-center">
    <div class="p-6 bg-white shadow sm:rounded-lg w-full max-w-2xl">
        <h4 class="text-lg font-medium text-gray-900 mb-6 text-center">Formulário Avaliação</h4>

        <form action="{{ !empty($dados->id) ? route('avaliacao.update', $dados->id) : route('avaliacao.store') }}" method="post" class="space-y-4">
            @csrf
            @if (!empty($dados->id))
                @method('PUT')
            @endif

            <input type="hidden" name="id" value="{{ old('id', $dados->id ?? '') }}"> <!--id av-->

            <input type="hidden" name="filme_id" value="{{ old('catalogo_id', $dados->catalogo_id ?? $catalogo->id ?? '') }}">

            <div>
                <label for="nota" class="block font-medium text-sm text-gray-700 mb-1">Nota</label>
                <input type="number" min="0" max="10" name="nota" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" value="{{ old('nota', $dados->nota ?? '') }}">
            </div>

            <div>
                <label for="comentario" class="block font-medium text-sm text-gray-700 mb-1">Comentário</label>
                <input type="text" name="comentario" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" value="{{ old('comentario', $dados->comentario ?? '') }}">
            </div>

            <div>
                <label for="spoiler" class="block font-medium text-sm text-gray-700 mb-1">Spoiler</label>
                <select name="spoiler" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                    <option value="0" {{ old('spoiler', $dados->spoiler ?? '') == 0 ? 'selected' : '' }}>Não</option>
                    <option value="1" {{ old('spoiler', $dados->spoiler ?? '') == 1 ? 'selected' : '' }}>Sim</option>
                </select>
            </div>

            <div class="flex items-center justify-center gap-3 pt-4">
                <button type="submit" style="background-color: #16a34a; color: #ffffff;" class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                    {{ !empty($dado->id) ? 'Atualizar' : 'Salvar' }}
                </button>
                <a href="{{ url('avaliacao') }}" style="background-color: #2563eb; color: #ffffff;" class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                    Voltar
                </a>
            </div>
        </form>
    </div>
</div>

@stop