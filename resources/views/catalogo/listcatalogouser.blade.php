@extends('main')
@section('titulo', 'Listagem de Catalogo')
@section('conteudo')

<div class="space-y-6 flex flex-col items-center">

    <!-- Box do Formulário de Busca -->
    <div class="p-6 bg-white shadow sm:rounded-lg w-full max-w-4xl flex flex-col items-center">
        <h3 class="text-lg font-medium text-gray-900 mb-4 text-center">Listagem de Catalogos</h3>

        <!--busca de dados por valor específico-->
        <form action="{{route('catalogo.searchuser')}}" method="post" class="w-full">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end justify-center">
                <div>
                    <label for="tipo" class="block font-medium text-sm text-gray-700">Tipo</label>
                    <select name="tipo" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                        <option value="titulo">Título</option>
                        <option value="genero">Genero</option>                
                        <option value="classificacao">Classificação</option>
                        <option value="ano">Ano</option>
                    </select>
                </div>

                <div>
                    <label for="valor" class="block font-medium text-sm text-gray-700">Valor</label>
                    <input type="text" name="valor" placeholder="Valor da busca" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" value="{{ request('valor') }}">
                </div>

                <div class="flex items-center justify-center gap-2">
                    <button type="submit" style="background-color: #2563eb; color: #ffffff;" class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                        Buscar
                    </button>

                </div>
            </div>
        </form>
    </div>

    <!-- Box da Tabela -->
    <div class="p-6 bg-white shadow sm:rounded-lg overflow-x-auto w-full max-w-4xl flex flex-col items-center">
        <table class="min-w-full divide-y divide-gray-200 text-center">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Poster</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Gênero</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Classificação</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ano</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Avaliação</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!--<php tem sua linguagem própria-->
                @foreach ($dados as $item)
                    <tr>
                        <th scope="row" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$item->id}}</th>
                        <td class="px-6 py-4 whitespace-nowrap flex justify-center"><img src="{{$item->url_poster}}" alt="Poster" class="w-20 rounded shadow-sm"></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{$item->titulo}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{$item->genero}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{$item->classificacao}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{$item->ano}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('avaliacao.create', ['catalogo_id' => $item->id]) }}" style="background-color: #2563eb; color: #ffffff;" class="px-3 py-1 border border-transparent rounded text-xs font-semibold uppercase hover:opacity-90">
                                Avaliar Filme
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@stop