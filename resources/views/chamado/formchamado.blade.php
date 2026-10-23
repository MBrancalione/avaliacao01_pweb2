@extends('main')
@section('titulo', 'Formulário de Chamados')
@section('conteudo')

@php
    // CORREÇÃO: no cadastro o $dado não existe, então as datas são calculadas aqui.
    // O input date exige o formato AAAA-MM-DD. No cadastro a data de criação já vem com o dia de hoje.
    $dataCriacao = isset($dado) ? $dado->data_criacao?->format('Y-m-d') : now()->format('Y-m-d');
    $dataEncerramento = isset($dado) ? $dado->data_encerramento?->format('Y-m-d') : null;
@endphp

<div class="flex justify-center">
    <div class="p-6 bg-white shadow sm:rounded-lg w-full max-w-2xl">
        <h4 class="text-lg font-medium text-gray-900 mb-6 text-center">Formulário de Chamados</h4>

        {{-- CORREÇÃO: class space-y-4 para os campos não ficarem colados --}}
        <form action="{{ isset($dado) ? route('chamado.update', $dado->id) : route('chamado.store') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Se for edição, adiciona a diretiva PUT do Laravel --}}
            @if(isset($dado))
                @method('PUT')
            @endif

            {{-- CORREÇÃO: era $dados, mas o controller manda $dado --}}
            <input type="hidden" name="id" value="{{ old('id', $dado->id ?? '') }}"> <!--id av-->

            <div>
                <label for="titulo" class="block font-medium text-sm text-gray-700 mb-1">Título</label>
                {{-- CORREÇÃO: name="nota" -> "titulo" (o controller valida 'titulo') --}}
                <input type="text" name="titulo" id="titulo"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                    value="{{ old('titulo', $dado->titulo ?? '') }}">
            </div>

            <div>
                <label for="descricao" class="block font-medium text-sm text-gray-700 mb-1">Descrição</label>
                {{-- CORREÇÃO: name="comentario" -> "descricao" --}}
                <input type="text" name="descricao" id="descricao"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                    value="{{ old('descricao', $dado->descricao ?? '') }}">
            </div>

            <div>
                <label for="data_criacao" class="block font-medium text-sm text-gray-700 mb-1">Data de Criação</label>
                {{-- CORREÇÃO: type="date" abre o minicalendário. O name era "comentario" --}}
                <input type="date" name="data_criacao" id="data_criacao"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                    value="{{ old('data_criacao', $dataCriacao) }}">
            </div>

            <div>
                <label for="data_encerramento" class="block font-medium text-sm text-gray-700 mb-1">Data de Encerramento</label>
                <input type="date" name="data_encerramento" id="data_encerramento"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                    value="{{ old('data_encerramento', $dataEncerramento) }}">
            </div>

            <div>
                <label for="status" class="block font-medium text-sm text-gray-700 mb-1">Status:</label>
                {{-- CORREÇÃO: name="spoiler" com 0/1. A coluna status é texto: Aberto/Em andamento/Fechado --}}
                <select name="status" id="status"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                    @foreach(['Aberto', 'Em andamento', 'Fechado'] as $s)
                        <option value="{{ $s }}" {{ old('status', $dado->status ?? 'Aberto') == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center justify-center gap-3 pt-4">
                <button type="submit" style="background-color: #16a34a; color: #ffffff;"
                    class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                    {{ !empty($dado->id) ? 'Atualizar' : 'Salvar' }}
                </button>
                <a href="{{ url('chamado') }}" style="background-color: #2563eb; color: #ffffff;"
                    class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                    Voltar
                </a>
            </div>
        </form>
    </div>
</div>

@stop