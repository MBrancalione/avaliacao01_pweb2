<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-center" style="color: #4c32a8;">
            {{ __('Formulário Planos') }}
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

                @php
                    if (!empty($dado->id)) {
                        $action = route('planos.update', $dado->id);
                    } else {
                        $action = route('planos.store');
                    }
                @endphp

                <h4 class="text-center" style="color: #4c32a8; font-size: 28px; font-weight: 700; margin: 0 0 4px;">Formulário Planos</h4>
                <p class="text-center text-gray-600" style="margin: 0 0 24px;">Preencha os dados do plano.</p>

                <!-- Exibição das mensagens de erro de validação -->
                @if ($errors->any())
                    <div class="fm-errors">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ $action }}" method="POST">
                    @csrf

                    @if (!empty($dado->id))
                        @method('PUT')
                    @endif

                    <input type="hidden" name="id" value="{{ old('id', $dado->id ?? '') }}">

                    <div class="fm-grid">
                        <div>
                            <label for="nome_plano" class="fm-label">Nome do Plano</label>
                            <input type="text" id="nome_plano" class="fm-input" name="nome_plano" value="{{ old('nome_plano', $dado->nome_plano ?? '') }}">
                        </div>

                        <div>
                            <label for="preco_mensal" class="fm-label">Preço Mensal</label>
                            <input type="number" step="0.01" id="preco_mensal" class="fm-input" name="preco_mensal" value="{{ old('preco_mensal', $dado->preco_mensal ?? '') }}">
                        </div>

                        <div>
                            <label for="limite_telas" class="fm-label">Limite de Telas</label>
                            <input type="number" id="limite_telas" class="fm-input" name="limite_telas" value="{{ old('limite_telas', $dado->limite_telas ?? '') }}">
                        </div>

                        <div>
                            <label for="resolucao_max" class="fm-label">Resolução Máxima</label>
                            <input type="text" id="resolucao_max" class="fm-input" name="resolucao_max" value="{{ old('resolucao_max', $dado->resolucao_max ?? '') }}" placeholder="Ex: Full HD, 4K">
                        </div>
                    </div>

                    <div class="fm-actions">
                        <button type="submit" class="fm-btn fm-btn-primary">
                            Salvar
                        </button>

                        <a href="{{ url('planos') }}" class="fm-btn fm-btn-ghost">
                            Voltar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
