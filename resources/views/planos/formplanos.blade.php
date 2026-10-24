<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-center" style="color: #4c32a8;">
            {{ __('Formulário Planos') }}
        </h2>
    </x-slot>

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

                <h4 class="text-center" style="color: #4c32a8; font-size: 28px; font-weight: 700; margin: 0 0 4px;">
                    Formulário Planos</h4>
                <p class="text-center text-gray-600" style="margin: 0 0 24px;">Preencha os dados do plano.</p>

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
                            <input type="text" id="nome_plano" class="fm-input" name="nome_plano"
                                value="{{ old('nome_plano', $dado->nome_plano ?? '') }}">
                        </div>

                        <div>
                            <label for="preco_mensal" class="fm-label">Preço Mensal</label>
                            <input type="number" step="0.01" id="preco_mensal" class="fm-input" name="preco_mensal"
                                value="{{ old('preco_mensal', $dado->preco_mensal ?? '') }}">
                        </div>

                        <div>
                            <label for="limite_telas" class="fm-label">Limite de Telas</label>
                            <input type="number" id="limite_telas" class="fm-input" name="limite_telas"
                                value="{{ old('limite_telas', $dado->limite_telas ?? '') }}">
                        </div>

                        <div>
                            <label for="resolucao_max" class="fm-label">Resolução Máxima</label>
                            <input type="text" id="resolucao_max" class="fm-input" name="resolucao_max"
                                value="{{ old('resolucao_max', $dado->resolucao_max ?? '') }}"
                                placeholder="Ex: Full HD, 4K">
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