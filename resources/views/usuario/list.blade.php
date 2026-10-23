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
                            <select name="tipo"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                <option value="name" {{ request('tipo') == 'name' ? 'selected' : '' }}>Nome</option>
                                <option value="email" {{ request('tipo') == 'email' ? 'selected' : '' }}>E-mail</option>
                                {{-- CORREÇÃO: a opção "Estado da Assinatura" estava repetida 3 vezes --}}
                                <option value="status_assinatura" {{ request('tipo') == 'status_assinatura' ? 'selected' : '' }}>Estado da Assinatura</option>
                            </select>
                        </div>

                        <div>
                            <label for="valor" class="block font-medium text-sm text-gray-700">Valor</label>
                            {{-- CORREÇÃO: value mantém o texto digitado depois da busca --}}
                            <input type="text" name="valor" placeholder="Pesquisar..." value="{{ request('valor') }}"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                        </div>

                        <div class="flex items-center justify-center gap-2">
                            <button type="submit" style="background-color: #2563eb; color: #ffffff;"
                                class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                                Buscar
                            </button>

                            {{-- CORREÇÃO: faltava o botão Novo (rota users.create, o "Salvar" do CRUD de usuário) --}}
                            <a href="{{ route('users.create') }}" style="background-color: #16a34a; color: #ffffff;"
                                class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                                Novo
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Box da tabela centralizado -->
            <div class="p-6 bg-white shadow sm:rounded-lg overflow-x-auto w-full max-w-4xl flex flex-col items-center">
                <table class="min-w-full divide-y divide-gray-200 text-center">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                #</th>
                            {{-- CORREÇÃO: o thead tinha 4 colunas e as linhas tinham 6 células. Agora bate, e entrou a Foto (critério 4) e o Plano (1:1) --}}
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Foto</th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nome</th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                E-mail</th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Plano</th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado da Assinatura</th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                colspan="2">
                                Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($dados as $item)
                            <tr>
                                <th scope="row" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $item->id }}
                                </th>

                                {{-- CORREÇÃO: foto na listagem (critério 4). Precisa do php artisan storage:link --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item->foto_perfil)
                                        <img src="{{ asset('storage/' . $item->foto_perfil) }}" alt="Foto"
                                            class="w-10 h-10 rounded-full object-cover mx-auto">
                                    @else
                                        <span class="text-xs text-gray-400">Sem foto</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $item->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $item->email }}</td>

                                {{-- CORREÇÃO: nome do plano (o controller carrega assinaturaEstado.plano com with()) --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $item->assinaturaEstado->plano->nome_plano ?? '-' }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $item->assinaturaEstado->status ?? 'Sem Assinatura' }}
                                </td>

                                <!-- Botão Editar -->
                                <td class="px-2 py-4 whitespace-nowrap text-sm">
                                    <a title="Editar" href="{{ route('users.edit', $item->id) }}"
                                        style="background-color: #eab308; color: #ffffff;"
                                        class="px-3 py-1 border border-transparent rounded text-xs font-semibold uppercase hover:opacity-90">
                                        Editar
                                    </a>
                                </td>

                                <!-- Botão Excluir -->
                                <td class="px-2 py-4 whitespace-nowrap text-sm">
                                    <form action="{{ route('users.destroy', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Excluir"
                                            style="background-color: #dc2626; color: #ffffff;"
                                            class="px-3 py-1 border border-transparent rounded text-xs font-semibold uppercase hover:opacity-90"
                                            onclick="return confirm('Deseja realmente excluir?')">
                                            Deletar
                                        </button>
                                    </form>
                                </td>
                            </tr> {{-- Tag </tr> deve fechar APÓS os botões --}}
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>