@extends('main')
@section('titulo', 'Listagem de Catalogo')
@section('conteudo')

<style>
    /* CSS próprio: funciona mesmo se o Tailwind do projeto não foi recompilado */
    .cat-wrap   { width: 100%; max-width: 1100px; margin: 0 auto; }
    .cat-grid   { display: grid; grid-template-columns: repeat(auto-fill, minmax(170px, 1fr)); gap: 22px; }

    .cat-card   { display: flex; flex-direction: column; }
    .cat-poster {
        position: relative; aspect-ratio: 2 / 3; border-radius: 12px; overflow: hidden;
        background: linear-gradient(160deg, #4c32a8, #8b6fe0);
        box-shadow: 0 4px 14px rgba(0,0,0,.18);
        transition: transform .25s ease, box-shadow .25s ease;
    }
    .cat-card:hover .cat-poster { transform: scale(1.06); box-shadow: 0 12px 28px rgba(76,50,168,.45); z-index: 5; }

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

    /* camada que aparece ao passar o mouse (estilo Netflix) */
    .cat-overlay {
        position: absolute; inset: 0; z-index: 2; display: flex; flex-direction: column;
        justify-content: flex-end; align-items: center; gap: 8px; padding: 14px; text-align: center;
        background: linear-gradient(to top, rgba(30,15,80,.95) 0%, rgba(30,15,80,.55) 55%, transparent 100%);
        opacity: 0; transition: opacity .25s ease;
    }
    .cat-card:hover .cat-overlay { opacity: 1; }
    .cat-genre  { background: #ede9f9; color: #4c32a8; font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 999px; }
    .cat-btn    {
        background: #4c32a8; color: #fff; font-size: 11px; font-weight: 700; text-transform: uppercase;
        letter-spacing: .08em; padding: 8px 14px; border-radius: 8px; text-decoration: none;
        border: 1px solid rgba(255,255,255,.35);
    }
    .cat-btn:hover { background: #3b2685; }

    .cat-info   { padding: 10px 2px 0; text-align: center; }
    .cat-title  { font-size: 14px; font-weight: 700; color: #4c32a8; line-height: 1.25;
                  display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .cat-year   { font-size: 12px; color: #6b7280; margin-top: 2px; }

    .cat-empty  { grid-column: 1 / -1; padding: 32px; text-align: center; color: #4b5563;
                  background: rgba(255,255,255,.9); border-radius: 16px; box-shadow: 0 4px 14px rgba(0,0,0,.1); }
</style>

<div class="space-y-6 flex flex-col items-center">

    <!-- Box do Formulário de Busca -->
    <div class="cat-wrap">
        <div class="p-6 bg-white shadow sm:rounded-lg w-full flex flex-col items-center" style="border-radius: 16px;">
            <h3 class="text-lg font-medium mb-1 text-center" style="color: #4c32a8; font-size: 28px; font-weight: 700;">Listagem de Catálogos</h3>
            <p class="mb-4 text-center text-gray-600">Encontre seus vídeos e conteúdos favoritos.</p>

            <!--busca de dados por valor específico-->
            <form action="{{route('filme.searchuser')}}" method="post" class="w-full">
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
                        <button type="submit" style="background-color: #4c32a8; color: #ffffff;" class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                            Buscar
                        </button>
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

                        @if($item->url_poster)
                            <img src="{{$item->url_poster}}" alt="Poster de {{$item->titulo}}" loading="lazy" onerror="this.style.display='none'">
                        @endif

                        <span class="cat-badge">{{$item->classificacao}}</span>

                        <div class="cat-overlay">
                            <span class="cat-genre">{{$item->GeneroFilme->genero_filme ?? 'Gênero não especificado'}}</span>
                            <a href="{{ route('avaliacao.create', ['filme_id' => $item->id]) }}" class="cat-btn">Avaliar Filme</a>
                            <a href="{{ route('filme.graficobarras', $item->id) }}" class="cat-btn">Ver notas</a>
                        </div>
                    </div>

                    <div class="cat-info">
                        <div class="cat-title">{{$item->titulo}}</div>
                        <div class="cat-year">{{$item->ano}}</div>
                    </div>
                </div>
            @empty
                <div class="cat-empty">Nenhum filme encontrado.</div>
            @endforelse

        </div>
    </div>

</div>

@stop
