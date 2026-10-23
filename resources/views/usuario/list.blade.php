<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-center" style="color: #4c32a8;">
            {{ __('Listagem de Usuários') }}
        </h2>
    </x-slot>

    <style>
        /* CSS próprio: funciona mesmo se o Tailwind do projeto não foi recompilado */
        .cat-wrap   { width: 100%; max-width: 1100px; margin: 0 auto; }
        .cat-pad    { padding-left: 16px; padding-right: 16px; }
        @media (min-width: 640px) { .cat-pad { padding-left: 24px; padding-right: 24px; } }

        /* Box da tabela */
        .pl-box   { background: #fff; border-radius: 16px; box-shadow: 0 4px 14px rgba(0,0,0,.1); padding: 24px; overflow-x: auto; width: 100%; }
        .pl-table { width: 100%; border-collapse: collapse; text-align: center; }
        .pl-table thead tr { background: #ede9f9; }
        .pl-table th.pl-th {
            padding: 12px 20px; font-size: 12px; font-weight: 700; text-transform: uppercase;
            letter-spacing: .06em; color: #4c32a8; white-space: nowrap;
        }
        .pl-table thead th:first-child { border-radius: 10px 0 0 10px; }
        .pl-table thead th:last-child  { border-radius: 0 10px 10px 0; }
        .pl-table tbody tr { border-bottom: 1px solid #f0edf9; transition: background .15s ease; }
        .pl-table tbody tr:last-child { border-bottom: 0; }
        .pl-table tbody tr:hover { background: #f8f6fe; }
        .pl-table td, .pl-table tbody th { padding: 14px 20px; font-size: 14px; color: #374151; white-space: nowrap; }
        .pl-table tbody th { font-weight: 700; color: #4c32a8; }
        .pl-name  { font-weight: 700; color: #4c32a8; }
        .pl-chip  { display: inline-block; background: #ede9f9; color: #4c32a8; font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 999px; }

        /* Foto de perfil */
        .pl-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; display: block; margin: 0 auto; border: 2px solid #ede9f9; box-shadow: 0 2px 6px rgba(76,50,168,.2); }
        .pl-nophoto { font-size: 12px; color: #9ca3af; }

        /* Ações: botões com ícone, mesmo estilo das outras listagens */
        .pl-actions { display: inline-flex; justify-content: center; gap: 8px; }
        .pl-actions form { margin: 0; display: inline-flex; }
        .pl-act {
            display: inline-flex; align-items: center; gap: 6px; padding: 7px 12px; background: #fff;
            border: 1px solid #e5e7eb; border-radius: 10px; cursor: pointer; text-decoration: none;
            font-family: inherit; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; line-height: 1;
            transition: background .2s ease, border-color .2s ease;
        }
        .pl-act svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .pl-act-edit   { color: #b45309; }
        .pl-act-edit:hover   { background: #fef3c7; border-color: #fcd34d; }
        .pl-act-delete { color: #dc2626; }
        .pl-act-delete:hover { background: #fee2e2; border-color: #fca5a5; }

        .pl-empty { padding: 32px; text-align: center; color: #4b5563; }
    </style>

    <div class="py-12">
        <div class="cat-wrap cat-pad space-y-6 flex flex-col items-center">

            <!-- Box do formulário de busca -->
            <div class="cat-wrap">
                <div class="p-6 bg-white shadow w-full flex flex-col items-center" style="border-radius: 16px;">
                    <h3 class="mb-1 text-center" style="color: #4c32a8; font-size: 28px; font-weight: 700;">Listagem de Usuários</h3>
                    <p class="mb-4 text-center text-gray-600">Gerencie os usuários da plataforma.</p>

                    <form action="{{ route('users.search') }}" method="post" class="w-full">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end justify-center">
                            <div>
                                <label for="tipo" class="block font-medium text-sm text-gray-700">Tipo</label>
                                <select name="tipo" id="tipo" class="border-gray-300 rounded-md shadow-sm w-full">
                                    <option value="name" {{ request('tipo') == 'name' ? 'selected' : '' }}>Nome</option>
                                    <option value="email" {{ request('tipo') == 'email' ? 'selected' : '' }}>E-mail</option>
                                    {{-- CORREÇÃO: a opção "Estado da Assinatura" estava repetida 3 vezes --}}
                                    <option value="status_assinatura" {{ request('tipo') == 'status_assinatura' ? 'selected' : '' }}>Estado da Assinatura</option>
                                </select>
                            </div>

                            <div>
                                <label for="valor" class="block font-medium text-sm text-gray-700">Valor</label>
                                {{-- CORREÇÃO: value mantém o texto digitado depois da busca --}}
                                <input type="text" name="valor" id="valor" placeholder="Pesquisar..." value="{{ request('valor') }}"
                                    class="border-gray-300 rounded-md shadow-sm w-full">
                            </div>

                            <div class="flex items-center justify-center gap-2">
                                <button type="submit" style="background-color: #4c32a8; color: #ffffff;"
                                    class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                                    Buscar
                                </button>

                                {{-- CORREÇÃO: faltava o botão Novo (rota users.create, o "Salvar" do CRUD de usuário) --}}
                                <a href="{{ route('users.create') }}" style="background-color: #16a34a; color: #ffffff;"
                                    class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                                    Novo
                                </a>

                                <a href="{{ route('users.pdf') }}" style="background-color: #ffffff; color: #4c32a8; border: 1px solid #4c32a8;"
                                    class="px-4 py-2 rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                                    PDF
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Box da tabela -->
            <div class="cat-wrap">
                <div class="pl-box">
                    <table class="pl-table">
                        <thead>
                            <tr>
                                <th scope="col" class="pl-th">#</th>
                                {{-- CORREÇÃO: o thead tinha 4 colunas e as linhas tinham 6 células. Agora bate, e entrou a Foto (critério 4) e o Plano (1:1) --}}
                                <th scope="col" class="pl-th">Foto</th>
                                <th scope="col" class="pl-th">Nome</th>
                                <th scope="col" class="pl-th">E-mail</th>
                                <th scope="col" class="pl-th">Plano</th>
                                <th scope="col" class="pl-th">Estado da Assinatura</th>
                                <th scope="col" class="pl-th" colspan="2">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dados as $item)
                                <tr>
                                    <th scope="row">{{ $item->id }}</th>

                                    {{-- CORREÇÃO: foto na listagem (critério 4). Precisa do php artisan storage:link --}}
                                    <td>
                                        @if($item->foto_perfil)
                                            <img src="{{ asset('storage/' . $item->foto_perfil) }}" alt="Foto" class="pl-avatar">
                                        @else
                                            <span class="pl-nophoto">Sem foto</span>
                                        @endif
                                    </td>

                                    <td class="pl-name">{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>

                                    {{-- CORREÇÃO: nome do plano (o controller carrega assinaturaEstado.plano com with()) --}}
                                    <td>
                                        {{ $item->assinaturaEstado->plano->nome_plano ?? '-' }}
                                    </td>

                                    <td>
                                        <span class="pl-chip">{{ $item->assinaturaEstado->status ?? 'Sem Assinatura' }}</span>
                                    </td>

                                    <!-- Botão Editar -->
                                    <td style="padding-right: 4px;">
                                        <a title="Editar" href="{{ route('users.edit', $item->id) }}" class="pl-act pl-act-edit">
                                            <svg viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                            Editar
                                        </a>
                                    </td>

                                    <!-- Botão Excluir -->
                                    <td style="padding-left: 4px;">
                                        <form action="{{ route('users.destroy', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Excluir" class="pl-act pl-act-delete"
                                                onclick="return confirm('Deseja realmente excluir?')">
                                                <svg viewBox="0 0 24 24"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                                                Deletar
                                            </button>
                                        </form>
                                    </td>
                                </tr> {{-- Tag </tr> deve fechar APÓS os botões --}}
                            @empty
                                <tr>
                                    <td colspan="8" class="pl-empty">Nenhum usuário encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
