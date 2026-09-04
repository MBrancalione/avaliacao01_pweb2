<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulário Planos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @php
                    if (!empty($dado->id)) {
                        $action = route('planos.update', $dado->id);
                    } else {
                        $action = route('planos.store');
                    }
                @endphp

                <!-- Exibição das mensagens de erro de validação -->
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h4 class="text-lg font-medium text-gray-900 mb-4">Formulário Planos</h4>

                <form action="{{ $action }}" method="POST">
                    @csrf

                    @if (!empty($dado->id))
                        @method('PUT')
                    @endif

                    <input type="hidden" name="id" value="{{ old('id', $dado->id ?? '') }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="nome_plano" class="block font-medium text-sm text-gray-700 mb-1">Nome do Plano</label>
                            <input type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" name="nome_plano" value="{{ old('nome_plano', $dado->nome_plano ?? '') }}">
                        </div>

                        <div>
                            <label for="preco_mensal" class="block font-medium text-sm text-gray-700 mb-1">Preço Mensal</label>
                            <input type="number" step="0.01" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" name="preco_mensal" value="{{ old('preco_mensal', $dado->preco_mensal ?? '') }}">
                        </div>

                        <div>
                            <label for="limite_telas" class="block font-medium text-sm text-gray-700 mb-1">Limite de Telas</label>
                            <input type="number" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" name="limite_telas" value="{{ old('limite_telas', $dado->limite_telas ?? '') }}">
                        </div>

                        <div>
                            <label for="resolucao_max" class="block font-medium text-sm text-gray-700 mb-1">Resolução Máxima</label>
                            <input type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" name="resolucao_max" value="{{ old('resolucao_max', $dado->resolucao_max ?? '') }}" placeholder="Ex: Full HD, 4K">
                        </div>
                    </div>

                    <div class="flex items-center gap-2 mt-4">
                        <button type="submit" style="background-color: #16a34a; color: #ffffff;" class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Salvar
                        </button>
                        
                        <a href="{{ url('planos') }}" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Voltar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>