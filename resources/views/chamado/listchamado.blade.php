@extends('main')
@section('titulo', 'Listagem de Chamados')
@section('conteudo')

    <div class="py-12">
        <div class="space-y-6 flex flex-col items-center">

            <div class="cat-wrap">
                <div class="p-6 bg-white shadow w-full flex flex-col items-center" style="border-radius: 16px;">
                    <h3 class="mb-1 text-center" style="color: #4c32a8; font-size: 28px; font-weight: 700;">Listagem de
                        Chamados</h3>
                    <p class="mb-4 text-center text-gray-600">Acompanhe e gerencie os chamados de suporte.</p>

                    <form action="{{ route('chamado.search') }}" method="post" class="w-full">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end justify-center">
                            <div>
                                <label for="tipo" class="block font-medium text-sm text-gray-700">Tipo</label>
                                <select name="tipo" id="tipo" class="border-gray-300 rounded-md shadow-sm w-full">
                                    <option value="titulo">Título</option>
                                    <option value="status">Status</option>
                                    <option value="data_criacao">Data de Criação (AAAA-MM-DD)</option>
                                </select>
                            </div>

                            <div>
                                <label for="valor" class="block font-medium text-sm text-gray-700">Valor</label>
                                <input type="text" name="valor" id="valor" placeholder="Pesquisar..."
                                    class="border-gray-300 rounded-md shadow-sm w-full">
                            </div>

                            <div class="flex items-center justify-center gap-2">
                                <button type="submit" style="background-color: #4c32a8; color: #ffffff;"
                                    class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                                    Buscar
                                </button>

                                @unless(Auth::user()->is_admin)
                                    <a href="{{ url('chamado/create') }}" style="background-color: #16a34a; color: #ffffff;"
                                        class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                                        Novo
                                    </a>
                                @endunless

                                <a href="{{ route('chamado.pdf') }}"
                                    style="background-color: #ffffff; color: #4c32a8; border: 1px solid #4c32a8;"
                                    class="px-4 py-2 rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                                    PDF
                                </a>
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
                                <th scope="col" class="pl-th">Título</th>
                                <th scope="col" class="pl-th">Descrição</th>
                                <th scope="col" class="pl-th">Status</th>
                                <th scope="col" class="pl-th">Data de Criação</th>
                                @if(Auth::user()->is_admin)
                                    <th scope="col" class="pl-th">Usuário</th>
                                @endif
                                <th scope="col" class="pl-th" colspan="2">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dados as $item)
                                <tr>
                                    <th scope="row">{{ $item->id }}</th>
                                    <td class="pl-name">{{ $item->titulo }}</td>
                                    <td class="pl-desc" title="{{ $item->descricao }}">{{ $item->descricao }}</td>
                                    <td><span class="pl-chip">{{ $item->status }}</span></td>
                                    <td>{{ $item->data_criacao?->format('d/m/Y H:i') }}</td>
                                    @if(Auth::user()->is_admin)
                                        <td>{{ $item->user->name ?? '-' }}</td>
                                    @endif

                                    <td style="padding-right: 4px;">
                                        <a title="Editar" href="{{ route('chamado.edit', $item->id) }}"
                                            class="pl-act pl-act-edit">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M12 20h9" />
                                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z" />
                                            </svg>
                                            Editar
                                        </a>
                                    </td>
                                    <td style="padding-left: 4px;">
                                        <form action="{{ route('chamado.destroy', $item->id) }}" method="post" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Excluir" class="pl-act pl-act-delete"
                                                onclick="return confirm('Deseja realmente excluir?')">
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
                                    <td colspan="8" class="pl-empty">Nenhum chamado encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection