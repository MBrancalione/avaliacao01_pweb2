<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-center" style="color: #4c32a8;">
            {{ __('Formulário Catálogo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="cat-wrap cat-pad">
            <div class="fm-box">

                <!--se vier o id, ele fará a validação para saber se é uma edição ou uma criaçl~~ao de formulario-->

                @php
                    if (!empty($dado->id)) {
                        $action = route('filme.update', $dado->id);
                    } else {
                        $action = route('filme.store');
                    }
                @endphp

                <h4 class="text-center" style="color: #4c32a8; font-size: 28px; font-weight: 700; margin: 0 0 4px;">
                    Formulário Filme</h4>
                <p class="text-center text-gray-600" style="margin: 0 0 24px;">Preencha os dados do filme.</p>

                @if ($errors->any())
                    <div class="fm-errors">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(!empty($dado->id))
                        @method('PUT')
                    @endif

                    <div class="fm-grid">
                        <input type="hidden" name="id" value="{{$dado->id ?? '' }}">

                        <div class="fm-span">
                            <label for="titulo" class="fm-label">Título</label>
                            <input type="text" id="titulo" class="fm-input" name="titulo"
                                value="{{ old('titulo', $dado->titulo ?? '') }}">
                        </div>

                        <div class="fm-span">
                            <label for="sinopse" class="fm-label">Sinopse</label>
                            <input type="textarea" id="sinopse" class="fm-input" name="sinopse"
                                value="{{ old('sinopse', $dado->sinopse ?? '') }}">
                        </div>

                        <div>
                            <label for="genero_filme" class="fm-label">Gênero</label>
                            <select name="genero_filme" id="genero_filme" class="fm-input">
                                <option value="">Selecione um gênero</option>
                                @foreach($generos as $g)
                                    <option value="{{ $g->id }}" {{ old('genero_filme', $dado->genero_filme ?? '') == $g->id ? 'selected' : '' }}>
                                        {{ $g->genero_filme }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="ano" class="fm-label">Ano</label>
                            <input type="text" id="ano" class="fm-input" name="ano"
                                value="{{ old('ano', $dado->ano ?? '') }}">
                        </div>

                        <div>
                            <label for="classificacao" class="fm-label">Classificação</label>
                            <select name="classificacao" id="classificacao" class="fm-input">
                                @foreach(['L', '10', '12', '14', '16', '18'] as $c)
                                    <option value="{{ $c }}" {{ old('classificacao', $dado->classificacao ?? '') == $c ? 'selected' : '' }}>{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="poster" class="fm-label">Poster</label>
                        <div class="fm-poster">
                            @if(isset($dado) && $dado->url_poster)
                                <img src="{{ $dado->url_poster }}" alt="Poster">
                            @endif
                            <div>
                                <input type="file" id="poster" name="poster" accept="image/*">
                                <p class="fm-hint">Escolha uma imagem para o poster do filme.</p>
                            </div>
                        </div>

                    </div>

                    <div class="fm-actions">
                        <button type="submit" class="fm-btn fm-btn-primary">
                            Salvar
                        </button>

                        <a href="{{ url('filmeadmin') }}" class="fm-btn fm-btn-ghost">
                            Voltar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>