@extends('main')
@section('titulo', 'Formulário Planos')
@section('conteudo')

<div class="flex justify-center">
    <div class="p-6 bg-white shadow sm:rounded-lg w-full max-w-2xl">
        @php
            if (!empty($dado->id)) {
                $action = route('planos.update', $dado->id);
            } else {
                $action = route('planos.store');
            }
        @endphp

        <h4 class="text-lg font-medium text-gray-900 mb-6 text-center">Formulário Planos</h4>

        <form action="{{ $action }}" method="post" class="space-y-4">
            @csrf
            @if (!empty($dado->id))
                @method('PUT')
            @endif

            <input type="hidden" name="id" value="{{ old('id', $dado->id ?? '') }}">

            <div>
                <label for="nome_plano" class="block font-medium text-sm text-gray-700 mb-1">Nome do Plano</label>
                <input type="text" name="nome_plano" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                    value="{{ old('nome_plano', $dado->nome_plano ?? '') }}">
            </div>

            <div>
                <label for="preco_mensal" class="block font-medium text-sm text-gray-700 mb-1">Preço Mensal</label>
                <input type="number" step="0.01" name="preco_mensal" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                    value="{{ old('preco_mensal', $dado->preco_mensal ?? '') }}">
            </div>

            <div>
                <label for="limite_telas" class="block font-medium text-sm text-gray-700 mb-1">Limite de Telas</label>
                <input type="number" name="limite_telas" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                    value="{{ old('limite_telas', $dado->limite_telas ?? '') }}">
            </div>

            <div>
                <label for="resolucao_max" class="block font-medium text-sm text-gray-700 mb-1">Resolução Máxima</label>
                <input type="text" name="resolucao_max" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                    value="{{ old('resolucao_max', $dado->resolucao_max ?? '') }}" placeholder="Ex: Full HD, 4K">
            </div>

            <div class="flex items-center justify-center gap-3 pt-4">
                <button type="submit" style="background-color: #16a34a; color: #ffffff;" class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                    Salvar
                </button>
                <a href="{{ url('planos') }}" style="background-color: #2563eb; color: #ffffff;" class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                    Voltar
                </a>
            </div>
        </form>
    </div>
</div>

@stop