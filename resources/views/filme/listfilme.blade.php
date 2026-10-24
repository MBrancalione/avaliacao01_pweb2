<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-center" style="color: #4c32a8;">
            {{ __('Listagem de Filmes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="cat-wrap cat-pad space-y-6 flex flex-col items-center">

            <div class="cat-wrap">
                <div class="p-6 bg-white shadow w-full flex flex-col items-center" style="border-radius: 16px;">
                    <h3 class="mb-1 text-center" style="color: #4c32a8; font-size: 28px; font-weight: 700;">Listagem de
                        Filmes</h3>
                    <p class="mb-4 text-center text-gray-600">Gerencie o catálogo da plataforma.</p>

                    <!--busca de dados por valor específico-->
                    <form action="{{ route('filme.searchadmin')}}" method="post" class="w-full">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end justify-center">
                            <div>
                                <label for="tipo" class="block font-medium text-sm text-gray-700">Tipo</label>
                                <select name="tipo" id="tipo" class="border-gray-300 rounded-md shadow-sm w-full">
                                    <option value="titulo">Título</option>
                                    <option value="genero_filme">Gênero</option>
                                    <option value="classificacao">Classificação</option>
                                    <option value="ano">Ano</option>
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
                                <a href="{{url('filme/create')}}" style="background-color: #16a34a; color: #ffffff;"
                                    class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                                    Novo</a> <!--linkagem de páginas Laravel (substituir tudo que estava como php)-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="cat-wrap">
                <div class="cat-grid">

                    @forelse ($dados as $item)

                        <div class="cat-card">
                            <div class="cat-poster">
                                <div class="cat-fallback">{{$item->titulo}}</div>

                                @if($item->poster)

                                    <img src="{{ $item->url_poster }}" alt="Poster de {{$item->titulo}}" loading="lazy"
                                        onerror="this.style.display='none'">
                                @endif

                                <span class="cat-id">#{{$item->id}}</span>
                                <span class="cat-badge">{{$item->classificacao}}</span>

                                <div class="cat-overlay">
                                    <span
                                        class="cat-genre">{{$item->GeneroFilme->genero_filme ?? 'Gênero não especificado'}}</span>
                                </div>
                            </div>

                            <div class="cat-info">
                                <div class="cat-title">{{$item->titulo}}</div>
                                <div class="cat-year">{{$item->ano}}</div>

                                <div class="cat-actions">
                                    <a class="cat-act cat-act-edit" title="Editar"
                                        href="{{route('filme.edit', $item->id)}}"> <!--passa o id como parâmetro-->
                                        <svg viewBox="0 0 24 24">
                                            <path d="M12 20h9" />
                                            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z" />
                                        </svg>
                                        Editar
                                    </a>

                                    <a class="cat-act cat-act-chart" title="Gráfico"
                                        href="{{ route('filme.graficobarras', $item->id) }}">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M3 3v18h18" />
                                            <path d="M8 17v-6" />
                                            <path d="M13 17V7" />
                                            <path d="M18 17v-9" />
                                        </svg>
                                        Gráfico
                                    </a>

                                    <form action="{{route('filme.destroy', $item->id)}}" method="POST">
                                        <!--pq precisa ser um form?-->
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cat-act cat-act-delete" title="Excluir"
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
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="cat-empty">Nenhum filme encontrado.</div>
                    @endforelse

                </div>
            </div>

        </div>
    </div>
</x-app-layout>