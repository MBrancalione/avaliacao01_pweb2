<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-center" style="color: #4c32a8;">
            {{ __('Listagem de Planos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="cat-wrap cat-pad space-y-6 flex flex-col items-center">

            <div class="cat-wrap">
                <div class="p-6 bg-white shadow w-full flex flex-col items-center" style="border-radius: 16px;">
                    <h3 class="mb-1 text-center" style="color: #4c32a8; font-size: 28px; font-weight: 700;">Listagem de
                        Planos</h3>
                    <p class="mb-4 text-center text-gray-600">Gerencie os planos da plataforma.</p>

                    <form action="{{ route('planos.search') }}" method="post" class="w-full">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end justify-center">
                            <div>
                                <label for="tipo" class="block font-medium text-sm text-gray-700">Tipo</label>
                                <select name="tipo" id="tipo" class="border-gray-300 rounded-md shadow-sm w-full">
                                    <option value="preco_mensal">Preço Mensal</option>
                                    <option value="limite_telas">Limite de Telas</option>
                                    <option value="resolucao_max">Resolução Máxima</option>
                                </select>
                            </div>

                            <div>
                                <label for="valor" class="block font-medium text-sm text-gray-700">Valor</label>
                                <input type="text" name="valor" id="valor" placeholder="Valor da busca"
                                    class="border-gray-300 rounded-md shadow-sm w-full" value="{{ request('valor') }}">
                            </div>

                            <div class="flex items-center justify-center gap-2">
                                <button type="submit" style="background-color: #4c32a8; color: #ffffff;"
                                    class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">Buscar</button>
                                <a href="{{ url('planos/create') }}" style="background-color: #16a34a; color: #ffffff;"
                                    class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">Novo</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="cat-wrap">
                <div class="pl-box">
                    <table class="pl-table">
                        <thead>
                            <tr>
                                <th scope="col" class="pl-th">#</th>
                                <th scope="col" class="pl-th">Nome do plano</th>
                                <th scope="col" class="pl-th">Preço Mensal</th>
                                <th scope="col" class="pl-th">Limite de Telas</th>
                                <th scope="col" class="pl-th">Resolução Máxima</th>
                                <th scope="col" class="pl-th" colspan="2">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dados as $item)
                                <tr>
                                    <th scope="row">{{ $item->id }}</th>
                                    <td class="pl-name">{{ $item->nome_plano }}</td>
                                    <td class="pl-price">R$ {{ number_format($item->preco_mensal, 2, ',', '.') }}</td>
                                    <td>{{ $item->limite_telas }}</td>
                                    <td><span class="pl-chip">{{ $item->resolucao_max }}</span></td>
                                    <td style="padding-right: 4px;">
                                        <a class="pl-act pl-act-edit" title="Editar"
                                            href="{{ route('planos.edit', $item->id) }}">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M12 20h9" />
                                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z" />
                                            </svg>
                                            Editar
                                        </a>
                                    </td>
                                    <td style="padding-left: 4px;">
                                        <form action="{{ route('planos.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="pl-act pl-act-delete" title="Excluir"
                                                onclick="return confirm('Deseja excluir?')">
                                                <svg viewBox="0 0 24 24">
                                                    <path d="M3 6h18" />
                                                    <path d="M8 6V4h8v2" />
                                                    <path d="M19 6l-1 14H6L5 6" />
                                                    <path d="M10 11v6" />
                                                    <path d="M14 11v6" />
                                                </svg>
                                                Deletar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="pl-empty">Nenhum plano encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>