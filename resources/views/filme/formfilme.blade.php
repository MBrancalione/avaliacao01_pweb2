@if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


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
                    if (!empty($dado->id)) {
                        $action = route('filme.update', $dado->id);
                    } else {
                        $action = route('filme.store');
                    }
                @endphp

                <h4 class="text-lg font-medium text-gray-900 mb-4">Formulário Filme</h4>
                <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                    <!--inserir a variável do php-->
                    @csrf
                    <!--formulario submetido faça a verificação se houver um formulário de um sistema externo, para bloquear-->

                    @if(!empty($dado->id))
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <input type="hidden" name="id" value="{{$dado->id ?? '' }}">
                        <!--fazer as altrações do laragon. quando for salvar os dados do formulário após validação e mantem os dados do formulário caso algum erro-->

                        <div>
                            <label for="titulo" class="block font-medium text-sm text-gray-700">Título</label>
                            <input type="text"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                name="titulo" value="{{ old('titulo', $dado->titulo ?? '') }}">
                        </div>

                        <div class="md:col-span-2">
                            <label for="sinopse" class="block font-medium text-sm text-gray-700">Sinopse</label>
                            <input type="text"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                name="sinopse" value="{{ old('sinopse', $dado->sinopse ?? '') }}">
                        </div>

                        <div>
    <label for="genero_filme_id" class="block font-medium text-sm text-gray-700">Gênero</label>
    <select name="genero_filme_id" id="genero_filme_id"
        class="text-black bg-white border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
        style="color-scheme: light;">
        <option value="" class="text-gray-500 bg-white">Selecione um gênero</option>
        @foreach($generos as $g)
            <option value="{{ $g->id }}" {{ old('genero_filme_id', $dado->genero_filme_id ?? '') == $g->id ? 'selected' : '' }} class="text-black bg-white">
                {{ $g->genero_filme }}
            </option>
        @endforeach
    </select>
</div>

                        <div>
                            <label for="ano" class="block font-medium text-sm text-gray-700">Ano</label>
                            <input type="text"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                name="ano" value="{{ old('ano', $dado->ano ?? '') }}">
                        </div>

                        <div>
                            <label for="classificacao"
                                class="block font-medium text-sm text-gray-700">Classificação</label>
                            <input type="text"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                name="classificacao" value="{{ old('classificacao', $dado->classificacao ?? '') }}">
                        </div>
                    </div>

                    <div>
                        <label for="poster" class="block font-medium text-sm text-gray-700">Poster</label>
                        @php
                            $nome_imagem = !empty($dado->poster) ? $dado->poster : 'sem_imagem.jpg'; // Verifica se há uma imagem associada ao registro, caso contrário, usa uma imagem padrão
                        @endphp
                        <img src="{{ asset('storage/' . $nome_imagem) }}" alt="Poster" class="mt-2 w-32 h-auto">
                        <!-- Exibe a imagem atual do poster, se houver -->
                        <input type="file" name="poster" value="{{ old('poster', $dado->poster ?? '') }}">
                        <!-- Campo de upload de arquivo para o poster -->
                    </div>

                    <div class="flex items-center gap-2 mt-4">
                        <button type="submit" style="background-color: #16a34a; color: #ffffff;"
                            class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Salvar
                        </button>

                        <a href="{{ url('filmeadmin') }}"
                            class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Voltar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>