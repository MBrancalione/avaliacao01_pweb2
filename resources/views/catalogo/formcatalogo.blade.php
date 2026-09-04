<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulário Catálogo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!--se vier o id, ele fará a validação para saber se é uma edição ou uma criaçl~~ao de formulario-->
                @php
                    if(!empty($dado->id)){
                        $action = route('catalogo.update', $dado->id);
                    } else {
                        $action = route('catalogo.store');
                    }
                @endphp

                <h4 class="text-lg font-medium text-gray-900 mb-4">Formulário Catalogo</h4>
                <form action="{{ $action }}" method="POST"><!--inserir a variável do php-->
                    @csrf <!--formulario submetido faça a verificação se houver um formulário de um sistema externo, para bloquear-->

                    @if(!empty($dado->id))
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <input type="hidden" name="id" value="{{$dado->id ?? '' }}"> <!--fazer as altrações do laragon. quando for salvar os dados do formulário após validação e mantem os dados do formulário caso algum erro-->
                        
                        <div>
                            <label for="url_poster" class="block font-medium text-sm text-gray-700">URL do Poster</label>
                            <input type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" name="url_poster" value="{{ old('url_poster', $dado->url_poster ?? '') }}">
                        </div>

                        <div>
                            <label for="titulo" class="block font-medium text-sm text-gray-700">Título</label>
                            <input type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" name="titulo" value="{{ old('titulo', $dado->titulo ?? '') }}">
                        </div>

                        <div class="md:col-span-2">
                            <label for="sinopse" class="block font-medium text-sm text-gray-700">Sinopse</label>
                            <input type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" name="sinopse" value="{{ old('sinopse', $dado->sinopse ?? '') }}">
                        </div>

                        <div>
                            <label for="genero" class="block font-medium text-sm text-gray-700">Gênero</label>
                            <input type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" name="genero" value="{{ old('genero', $dado->genero ?? '') }}">
                        </div>

                        <div>
                            <label for="ano" class="block font-medium text-sm text-gray-700">Ano</label>
                            <input type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" name="ano" value="{{ old('ano', $dado->ano ?? '') }}">
                        </div>

                        <div>
                            <label for="classificacao" class="block font-medium text-sm text-gray-700">Classificação</label>
                            <input type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" name="classificacao" value="{{ old('classificacao', $dado->classificacao ?? '') }}">
                        </div>
                    </div>

                    <div class="flex items-center gap-2 mt-4">
                        <button type="submit" style="background-color: #16a34a; color: #ffffff;" class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Salvar
                        </button>
                        
                        <a href="{{ url('catalogoadmin') }}" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Voltar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>