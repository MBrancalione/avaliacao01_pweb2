@extends('main')
@section('titulo', 'Listagem de Avaliações')
@section('conteudo')

<div class="space-y-6 flex flex-col items-center">
    <div class="lst-search">
        <div class="p-6 bg-white shadow w-full flex flex-col items-center" style="border-radius: 16px;">
            <h3 class="mb-1 text-center" style="color: #4c32a8; font-size: 28px; font-weight: 700;">Listagem de
                Avaliações</h3>
            <p class="mb-4 text-center text-gray-600">Veja o que a comunidade está achando dos filmes.</p>

            <form action="{{ route('avaliacao.search') }}" method="post" class="w-full">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end justify-center">
                    <div>
                        <label for="tipo" class="block font-medium text-sm text-gray-700">Tipo</label>
                        <select name="tipo" id="tipo" class="border-gray-300 rounded-md shadow-sm w-full">
                            <option value="titulo" {{ request('tipo') == 'titulo' ? 'selected' : '' }}>Título do filme
                            </option>
                            <option value="nota" {{ request('tipo') == 'nota' ? 'selected' : '' }}>Nota</option>
                            <option value="comentario" {{ request('tipo') == 'comentario' ? 'selected' : '' }}>Comentário
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="valor" class="block font-medium text-sm text-gray-700">Valor</label>
                        <input type="text" name="valor" id="valor" placeholder="Pesquisar..."
                            value="{{ request('valor') }}" class="border-gray-300 rounded-md shadow-sm w-full">
                    </div>

                    <div class="flex items-center justify-center gap-2">
                        <button type="submit" style="background-color: #4c32a8; color: #ffffff;"
                            class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                            Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="lst-table">
        <div class="pl-box">
            <table class="pl-table">
                <thead>
                    <tr>
                        <th scope="col" class="pl-th">#</th>
                        <th scope="col" class="pl-th">Filme</th>
                        <th scope="col" class="pl-th">Usuário</th>
                        <th scope="col" class="pl-th">Nota</th>
                        <th scope="col" class="pl-th">Comentário</th>
                        <th scope="col" class="pl-th">Spoiler</th>
                        <th scope="col" class="pl-th" colspan="2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dados as $item)
                        <tr>
                            <th scope="row">{{ $item->id }}</th>
                            <td class="pl-name">{{ $item->filme->titulo ?? '-' }}</td>
                            <td>{{ $item->user->name ?? '-' }}</td> <!--apresenta por uma propriedade de user, o nome-->
                            <td>
                                <span class="pl-note">
                                    <svg viewBox="0 0 24 24">
                                        <path
                                            d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01z" />
                                    </svg>
                                    {{ $item->nota }}
                                </span>
                            </td>
                            <td class="pl-comment">{{ $item->comentario }}</td>
                            <td>
                                <span
                                    class="pl-chip {{ $item->spoiler ? 'pl-spoiler-yes' : 'pl-spoiler-no' }}">{{ $item->spoiler ? 'Sim' : 'Não' }}</span>
                            </td>

                            @if(Auth::user()->is_admin || $item->user_id == Auth::id())
                                <td style="padding-right: 4px;">
                                    <a title="Editar" href="{{ route('avaliacao.edit', $item->id) }}"
                                        class="pl-act pl-act-edit">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M12 20h9" />
                                            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z" />
                                        </svg>
                                        Editar
                                    </a>
                                </td>
                                <td style="padding-left: 4px;">
                                    <form action="{{ route('avaliacao.destroy', $item->id) }}" method="post" class="inline">
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
                            @else
                                <td style="padding-right: 4px;">
                                    <span class="pl-act pl-act-disabled" title="Só o autor da avaliação pode editar">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M12 20h9" />
                                            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z" />
                                        </svg>
                                        Editar
                                    </span>
                                </td>
                                <td style="padding-left: 4px;">
                                    <span class="pl-act pl-act-disabled" title="Só o autor da avaliação pode excluir">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M3 6h18" />
                                            <path d="M8 6V4h8v2" />
                                            <path d="M19 6l-1 14H6L5 6" />
                                            <path d="M10 11v6" />
                                            <path d="M14 11v6" />
                                        </svg>
                                        Deletar
                                    </span>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="pl-empty">Nenhuma avaliação encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@stop