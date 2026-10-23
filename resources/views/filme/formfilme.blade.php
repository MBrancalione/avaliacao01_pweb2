<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-center" style="color: #4c32a8;">
            {{ __('Formulário Catálogo') }}
        </h2>
    </x-slot>

    <style>
        /* CSS próprio: funciona mesmo se o Tailwind do projeto não foi recompilado */
        .cat-wrap   { width: 100%; max-width: 1100px; margin: 0 auto; }
        .cat-pad    { padding-left: 16px; padding-right: 16px; }
        @media (min-width: 640px) { .cat-pad { padding-left: 24px; padding-right: 24px; } }

        /* Box do formulário */
        .fm-box   { max-width: 860px; margin: 0 auto; background: #fff; border-radius: 16px; box-shadow: 0 4px 14px rgba(0,0,0,.1); padding: 32px; }
        .fm-grid  { display: grid; grid-template-columns: 1fr; gap: 18px; margin-bottom: 22px; }
        @media (min-width: 768px) { .fm-grid { grid-template-columns: 1fr 1fr; } .fm-span { grid-column: span 2; } }

        .fm-label { display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151; }
        .fm-input {
            width: 100%; padding: 10px 12px; font-size: 14px; color: #111827; background: #fff;
            border: 1px solid #d1d5db; border-radius: 10px; box-shadow: 0 1px 2px rgba(0,0,0,.04);
            transition: border-color .15s ease, box-shadow .15s ease; color-scheme: light;
        }
        .fm-input:focus { outline: none; border-color: #4c32a8; box-shadow: 0 0 0 3px rgba(76,50,168,.18); }

        /* Poster */
        .fm-poster {
            display: flex; flex-wrap: wrap; align-items: center; gap: 20px; padding: 18px;
            background: #f8f6fe; border: 1px dashed #c4b5fd; border-radius: 14px;
        }
        .fm-poster img { width: 110px; aspect-ratio: 2 / 3; object-fit: cover; border-radius: 10px; box-shadow: 0 4px 14px rgba(76,50,168,.3); background: #ede9f9; }
        .fm-poster input[type=file] { font-size: 13px; color: #4b5563; }
        .fm-poster input[type=file]::file-selector-button {
            margin-right: 12px; padding: 8px 14px; border: 0; border-radius: 8px; cursor: pointer;
            background: #4c32a8; color: #fff; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em;
        }
        .fm-poster input[type=file]::file-selector-button:hover { opacity: .9; }
        .fm-hint { font-size: 12px; color: #6b7280; margin-top: 6px; }

        /* Botões */
        .fm-actions { display: flex; justify-content: center; gap: 10px; margin-top: 26px; padding-top: 22px; border-top: 1px solid #f0edf9; }
        .fm-btn {
            display: inline-flex; align-items: center; gap: 6px; padding: 10px 22px; border-radius: 10px; cursor: pointer;
            font-family: inherit; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em;
            text-decoration: none; line-height: 1; transition: opacity .15s ease, background .15s ease;
        }
        .fm-btn-primary { background: #4c32a8; color: #fff; border: 1px solid transparent; }
        .fm-btn-primary:hover { opacity: .9; }
        .fm-btn-ghost   { background: #fff; color: #4c32a8; border: 1px solid #4c32a8; }
        .fm-btn-ghost:hover { background: #ede9f9; }

        /* Erros de validação */
        .fm-errors { margin-bottom: 22px; padding: 14px 16px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; color: #991b1b; font-size: 14px; }
        .fm-errors ul { margin: 0; padding-left: 20px; list-style: disc; }
    </style>

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

                <h4 class="text-center" style="color: #4c32a8; font-size: 28px; font-weight: 700; margin: 0 0 4px;">Formulário Filme</h4>
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
                    <!--inserir a variável do php-->
                    @csrf
                    <!--formulario submetido faça a verificação se houver um formulário de um sistema externo, para bloquear-->

                    @if(!empty($dado->id))
                        @method('PUT')
                    @endif

                    <div class="fm-grid">
                        <input type="hidden" name="id" value="{{$dado->id ?? '' }}">
                        <!--fazer as altrações do laragon. quando for salvar os dados do formulário após validação e mantem os dados do formulário caso algum erro-->

                        <div class="fm-span">
                            <label for="titulo" class="fm-label">Título</label>
                            <input type="text" id="titulo" class="fm-input"
                                name="titulo" value="{{ old('titulo', $dado->titulo ?? '') }}">
                        </div>

                        <div class="fm-span">
                            <label for="sinopse" class="fm-label">Sinopse</label>
                            <input type="text" id="sinopse" class="fm-input"
                                name="sinopse" value="{{ old('sinopse', $dado->sinopse ?? '') }}">
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
                            <input type="text" id="ano" class="fm-input"
                                name="ano" value="{{ old('ano', $dado->ano ?? '') }}">
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
                        @php
                            $nome_imagem = !empty($dado->poster) ? $dado->poster : 'sem_imagem.jpg'; // Verifica se há uma imagem associada ao registro, caso contrário, usa uma imagem padrão
                        @endphp
                        <div class="fm-poster">
                            <img src="{{ asset('storage/' . $nome_imagem) }}" alt="Poster">
                            <div>
                                <input type="file" id="poster" name="poster" value="{{ old('poster', $dado->poster ?? '') }}">
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
