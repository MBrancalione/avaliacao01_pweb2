<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Listagem de Usuários') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 flex flex-col items-center">
            
            <!-- Box do formulário de busca centralizado -->
            <div class="p-6 bg-white shadow sm:rounded-lg w-full max-w-4xl flex flex-col items-center">

                <form action="{{ route('users.search') }}" method="post" class="w-full">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end justify-center">
                        <div>
                            <label for="tipo" class="block font-medium text-sm text-gray-700">Tipo</label>
                            <select name="tipo" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                <option value="name">Nome</option>
                                <option value="email">E-mail</option>
                            </select>
                        </div>

                        <div>
                            <label for="valor" class="block font-medium text-sm text-gray-700">Valor</label>
                            <input type="text" name="valor" placeholder="Pesquisar..." class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                        </div>

                        <div class="flex items-center justify-center">
                            <button type="submit" style="background-color: #2563eb; color: #ffffff;" class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                                Buscar
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Box da tabela centralizado -->
            <div class="p-6 bg-white shadow sm:rounded-lg overflow-x-auto w-full max-w-4xl flex flex-col items-center">
                <table class="min-w-full divide-y divide-gray-200 text-center">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">E-mail</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Estado da Assinatura</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($dados as $item)
                            <tr>
                                <th scope="row" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->id }}</th>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $item->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $item->email }}</td>
                                <!-- Exibe o valor do campo 'status' da tabela relacionada -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $item->assinaturaEstado->status ?? 'Sem Assinatura' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>