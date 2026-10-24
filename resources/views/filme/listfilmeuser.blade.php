@extends('main')
@section('titulo', 'Listagem de Catalogo')
@section('conteudo')

<div class="space-y-6 flex flex-col items-center">

    <div class="cat-wrap">
        <div class="p-6 bg-white shadow sm:rounded-lg w-full flex flex-col items-center" style="border-radius: 16px;">
            <h3 class="text-lg font-medium mb-1 text-center" style="color: #4c32a8; font-size: 28px; font-weight: 700;">
                Listagem de Catálogos</h3>
            <p class="mb-4 text-center text-gray-600">Encontre seus vídeos e conteúdos favoritos.</p>

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
                        <input type="text" name="valor" id="valor" placeholder="Valor da busca"
                            class="border-gray-300 rounded-md shadow-sm w-full" value="{{ request('valor') }}">
                    </div>

                    <div class="flex items-center justify-center gap-2">
                        <button type="submit" style="background-color: #4c32a8; color: #ffffff;"
                            class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                            Buscar
                        </button>

                        <a href="{{ route('filme.graficogeneros') }}"
                            style="background-color: #ffffff; color: #4c32a8; border: 1px solid #4c32a8;"
                            class="px-4 py-2 rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90">
                            Gráfico de setores
                        </a>
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

                        @if($item->url_poster)
                            <img src="{{$item->url_poster}}" alt="Poster de {{$item->titulo}}" loading="lazy"
                                onerror="this.style.display='none'">
                        @endif

                        <span class="cat-badge">{{$item->classificacao}}</span>

                        <div class="cat-overlay">
                            <span class="cat-genre">{{$item->GeneroFilme->genero_filme ?? 'Gênero não especificado'}}</span>
                            <a href="{{ route('avaliacao.create', ['filme_id' => $item->id]) }}" class="cat-btn">Avaliar
                                Filme</a>
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