@extends('main')
@section('titulo', 'Listagem de Avaliações')
@section('conteudo')

<div class="space-y-6 flex flex-col items-center">

    <!-- Box do Formulário de Busca -->
    <div class="p-6 bg-white shadow sm:rounded-lg w-full max-w-4xl flex flex-col items-center">
        <h3 class="text-lg font-medium text-gray-900 mb-4 text-center">Listagem de Avaliações</h3>

        <form action="{{ route('avaliacao.search') }}" method="post" class="w-full">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end justify-center">
                <div>
                    <label for="tipo" class="block font-medium text-sm text-gray-700">Tipo</label>
                    <select name="tipo" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                        <option value="nota">Nota</option>
                    </select>
                </div>

                <div>
                    <label for="valor" class="block font-medium text-sm text-gray-700">Valor</label>
                    <input type="text" name="valor" placeholder="Pesquisar..." class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                </div>

                <div class="flex items-center justify-center gap-2">
                    <button type="submit" style="background-color: #2563eb; color: #ffffff;" class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                        Buscar
                    </button>

                    <a href="{{ url('avaliacao/create') }}" style="background-color: #16a34a; color: #ffffff;" class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                        Novo
                    </a>
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
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nota</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Comentário</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Spoiler</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" colspan="2">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($dados as $item)
                    <tr>
                        <th scope="row" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->id }}</th>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $item->nota }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $item->comentario }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $item->spoiler ? 'Sim' : 'Não' }}</td>
                        <td class="px-2 py-4 whitespace-nowrap text-sm">
                            <a title="Editar" href="{{ route('avaliacao.edit', $item->id) }}" style="background-color: #eab308; color: #ffffff;" class="px-3 py-1 border border-transparent rounded text-xs font-semibold uppercase hover:opacity-90">
                                Editar
                            </a>
                        </td>
                        <td class="px-2 py-4 whitespace-nowrap text-sm">
                            <form action="{{ route('avaliacao.destroy', $item->id) }}" method="post" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Excluir" style="background-color: #dc2626; color: #ffffff;" class="px-3 py-1 border border-transparent rounded text-xs font-semibold uppercase hover:opacity-90" onclick="return confirm('Deseja realmente excluir?')">
                                    Deletar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@stop