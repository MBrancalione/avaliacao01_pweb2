<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-center" style="color: #4c32a8;">
            {{ __('Listagem de Filmes') }}
        </h2>
    </x-slot>

    <style>
        /* CSS próprio: funciona mesmo se o Tailwind do projeto não foi recompilado */
        .cat-wrap   { width: 100%; max-width: 1100px; margin: 0 auto; }
        .cat-pad    { padding-left: 16px; padding-right: 16px; }
        @media (min-width: 640px) { .cat-pad { padding-left: 24px; padding-right: 24px; } }
        .cat-grid   { display: grid; grid-template-columns: repeat(auto-fill, minmax(190px, 1fr)); gap: 22px; }

        .cat-card   { display: flex; flex-direction: column; }
        .cat-poster {
            position: relative; aspect-ratio: 2 / 3; border-radius: 12px; overflow: hidden;
            background: linear-gradient(160deg, #4c32a8, #8b6fe0);
            box-shadow: 0 4px 14px rgba(0,0,0,.18);
            transition: transform .25s ease, box-shadow .25s ease;
        }
        .cat-card:hover .cat-poster { transform: scale(1.04); box-shadow: 0 12px 28px rgba(76,50,168,.45); z-index: 5; }

        /* texto que aparece quando a imagem do poster não carrega */
        .cat-fallback {
            position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;
            padding: 14px; text-align: center; color: #fff; font-weight: 700; font-size: 15px;
        }
        .cat-poster img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }

        .cat-badge {
            position: absolute; top: 8px; right: 8px; z-index: 3;
            background: #4c32a8; color: #fff; font-size: 11px; font-weight: 700;
            padding: 3px 8px; border-radius: 6px; box-shadow: 0 2px 6px rgba(0,0,0,.3);
        }
        .cat-id {
            position: absolute; top: 8px; left: 8px; z-index: 3;
            background: rgba(255,255,255,.9); color: #4c32a8; font-size: 11px; font-weight: 700;
            padding: 3px 8px; border-radius: 6px;
        }

        /* camada que aparece ao passar o mouse (estilo Netflix) */
        .cat-overlay {
            position: absolute; inset: 0; z-index: 2; display: flex; flex-direction: column;
            justify-content: flex-end; align-items: center; gap: 8px; padding: 14px; text-align: center;
            background: linear-gradient(to top, rgba(30,15,80,.95) 0%, rgba(30,15,80,.55) 55%, transparent 100%);
            opacity: 0; transition: opacity .25s ease;
        }
        .cat-card:hover .cat-overlay { opacity: 1; }
        .cat-genre  { background: #ede9f9; color: #4c32a8; font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 999px; }

        .cat-info   { padding: 10px 2px 0; text-align: center; }
        .cat-title  { font-size: 14px; font-weight: 700; color: #4c32a8; line-height: 1.25;
                      display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .cat-year   { font-size: 12px; color: #6b7280; margin-top: 2px; }

        /* Ações do admin: barra segmentada, 3 colunas iguais, sempre visível (funciona no celular) */
        .cat-actions {
            display: grid; grid-template-columns: repeat(3, 1fr); margin-top: 12px;
            background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;
            box-shadow: 0 2px 8px rgba(76,50,168,.08);
        }
        .cat-actions form { margin: 0; display: flex; }
        .cat-act {
            flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px;
            padding: 9px 4px; background: transparent; border: 0; cursor: pointer; text-decoration: none;
            font-family: inherit; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em;
            line-height: 1; transition: background .2s ease, color .2s ease;
        }
        .cat-act svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .cat-actions > * + * { border-left: 1px solid #e5e7eb; }

        .cat-act-edit   { color: #b45309; }
        .cat-act-edit:hover   { background: #fef3c7; }
        .cat-act-chart  { color: #4c32a8; }
        .cat-act-chart:hover  { background: #ede9f9; }
        .cat-act-delete { color: #dc2626; }
        .cat-act-delete:hover { background: #fee2e2; }

        .cat-empty  { grid-column: 1 / -1; padding: 32px; text-align: center; color: #4b5563;
                      background: rgba(255,255,255,.9); border-radius: 16px; box-shadow: 0 4px 14px rgba(0,0,0,.1); }
    </style>

    <div class="py-12">
        <div class="cat-wrap cat-pad space-y-6 flex flex-col items-center">

            <!-- Box do Formulário de Busca -->
            <div class="cat-wrap">
                <div class="p-6 bg-white shadow w-full flex flex-col items-center" style="border-radius: 16px;">
                    <h3 class="mb-1 text-center" style="color: #4c32a8; font-size: 28px; font-weight: 700;">Listagem de Filmes</h3>
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
                                <input type="text" name="valor" id="valor" placeholder="Valor da busca" class="border-gray-300 rounded-md shadow-sm w-full" value="{{ request('valor') }}">
                            </div>

                            <div class="flex items-center justify-center gap-2">
                                <button type="submit" style="background-color: #4c32a8; color: #ffffff;" class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">Buscar</button>
                                <a href="{{url('filme/create')}}" style="background-color: #16a34a; color: #ffffff;" class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90"> Novo</a> <!--linkagem de páginas Laravel (substituir tudo que estava como php)-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Grade de posters (estilo Netflix) -->
            <div class="cat-wrap">
                <div class="cat-grid">

                    <!--<php tem sua linguagem própria-->
                    @forelse ($dados as $item)
                        <div class="cat-card">
                            <div class="cat-poster">
                                <!-- Aparece por trás; só fica visível se a imagem falhar -->
                                <div class="cat-fallback">{{$item->titulo}}</div>

                                @if($item->poster)
                                    <img src="{{ asset('storage/' . $item->poster) }}" alt="Poster de {{$item->titulo}}" loading="lazy" onerror="this.style.display='none'">
                                @endif

                                <span class="cat-id">#{{$item->id}}</span>
                                <span class="cat-badge">{{$item->classificacao}}</span>

                                <div class="cat-overlay">
                                    <span class="cat-genre">{{$item->GeneroFilme->genero_filme ?? 'Gênero não especificado'}}</span>
                                </div>
                            </div>

                            <div class="cat-info">
                                <div class="cat-title">{{$item->titulo}}</div>
                                <div class="cat-year">{{$item->ano}}</div>

                                <!--botões de ação para chamar função de edit e destroy-->
                                <div class="cat-actions">
                                    <a class="cat-act cat-act-edit" title="Editar" href="{{route('filme.edit', $item->id)}}"> <!--passa o id como parâmetro-->
                                        <svg viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                        Editar
                                    </a>

                                    <a class="cat-act cat-act-chart" title="Gráfico" href="{{ route('filme.graficobarras', $item->id) }}">
                                        <svg viewBox="0 0 24 24"><path d="M3 3v18h18"/><path d="M8 17v-6"/><path d="M13 17V7"/><path d="M18 17v-9"/></svg>
                                        Gráfico
                                    </a>

                                    <form action="{{route('filme.destroy', $item->id)}}" method="POST"> <!--pq precisa ser um form?-->
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cat-act cat-act-delete" title="Excluir" onclick="return confirm('Deseja excluir?')">
                                            <svg viewBox="0 0 24 24"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
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
