@extends('main')
@section('titulo', 'Formulário de Chamados')
@section('conteudo')

<div class="flex justify-center">
    <div class="p-6 bg-white shadow sm:rounded-lg w-full max-w-2xl">
        <h4 class="text-lg font-medium text-gray-900 mb-6 text-center">Formulário de Chamados</h4>

        <form action="{{ !empty($dados->id) ? route('chamado.update', $dados->id) : route('chamado.store') }}" method="post" class="space-y-4">
            @csrf
            @if (!empty($dados->id))
                @method('PUT')
            @endif

            <input type="hidden" name="id" value="{{ old('id', $dados->id ?? '') }}"> <!--id av-->
            <div>
                <label for="nota" class="block font-medium text-sm text-gray-700 mb-1">Título</label>
                <input type="text" name="nota" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" value="{{ old('nota', $dados->titulo ?? '') }}">
            </div>

            <div>
                <label for="comentario" class="block font-medium text-sm text-gray-700 mb-1">Descrição</label>
                <input type="text" name="comentario" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" value="{{ old('comentario', $dados->descricao ?? '') }}">
            </div>
            
            <div>
                <label for="comentario" class="block font-medium text-sm text-gray-700 mb-1">Data de Criação</label>
                <input type="text" name="comentario" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" value="{{ old('comentario', $dados->data_criacao ?? '') }}">
            </div>

            <div>
                <label for="spoiler" class="block font-medium text-sm text-gray-700 mb-1">Status:</label>
                <select name="spoiler" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                    <option value="0" {{ old('spoiler', $dados->spoiler ?? '') == 0 ? 'selected' : '' }}>Fechado</option>
                    <option value="1" {{ old('spoiler', $dados->spoiler ?? '') == 1 ? 'selected' : '' }}>Aberto</option>
                </select>
            </div>

            <div class="flex items-center justify-center gap-3 pt-4">
                <button type="submit" style="background-color: #16a34a; color: #ffffff;" class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                    {{ !empty($dado->id) ? 'Atualizar' : 'Salvar' }}
                </button>
                <a href="{{ url('chamado') }}" style="background-color: #2563eb; color: #ffffff;" class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                    Voltar
                </a>
            </div>
        </form>
    </div>
</div>

@stop