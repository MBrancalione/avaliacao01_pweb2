<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Listagem de Planos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 flex flex-col items-center">
            
            <!-- Box do Formulário de Busca -->
            <div class="p-6 bg-white shadow sm:rounded-lg w-full max-w-4xl flex flex-col items-center">
                <form action="{{ route('planos.search') }}" method="post" class="w-full">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end justify-center">
                        <div>
                            <label for="tipo" class="block font-medium text-sm text-gray-700">Tipo</label>
                            <select name="tipo" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                <option value="nome_planos">Nome do plano</option>
                                <option value="preco_mensal">Preço Mensal</option>
                                <option value="limite_telas">Limite de Telas</option>
                                <option value="resolucao_max">Resolução Máxima</option>
                            </select>
                        </div>

                        <div>
                            <label for="valor" class="block font-medium text-sm text-gray-700">Valor</label>
                            <input type="text" name="valor" placeholder="Valor da busca" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" value="{{ request('valor') }}">
                        </div>

                        <div class="flex items-center justify-center gap-2">
                            <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500">Buscar</button>
                            <a href="{{ url('planos/create') }}" style="background-color: #16a34a; color: #ffffff;" class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">Novo</a>
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
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nome do plano</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Preço Mensal</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Limite de Telas</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Resolução Máxima</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" colspan="2">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($dados as $item)
                            <tr>
                                <th scope="row" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->id }}</th>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $item->nome_plano }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">R$ {{ number_format($item->preco_mensal, 2, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $item->limite_telas }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $item->resolucao_max }}</td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm">
                                    <a style="background-color: #f59e0b; color: #ffffff; padding: 4px 12px; border-radius: 4px; font-weight: bold; text-decoration: none; font-size: 12px; text-transform: uppercase;" title="Editar" href="{{ route('planos.edit', $item->id) }}">Editar</a>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm">
                                    <form action="{{ route('planos.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-semibold uppercase" title="Excluir" onclick="return confirm('Deseja excluir?')">Deletar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>