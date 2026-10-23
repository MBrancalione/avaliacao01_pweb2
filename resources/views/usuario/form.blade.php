<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- CORREÇÃO: era "Formulário Catálogo" (copiado do form de filme) --}}
            {{ __('Formulário Usuário') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- CORREÇÃO: o bloco de erros estava FORA do <x-app-layout> e aparecia acima do menu. Agora fica dentro do card --}}
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!--se vier o id, ele fará a validação para saber se é uma edição ou uma criaçl~~ao de formulario-->

                @php
                    if (!empty($dado->id)) {
                        $action = route('users.update', $dado->id);
                    } else {
                        $action = route('users.store');
                    }
                @endphp

                <h4 class="text-lg font-medium text-gray-900 mb-4">Formulário users</h4>
                {{-- CORREÇÃO: sem enctype, porque este form não tem upload (a foto o próprio usuário envia no perfil) --}}
                <form action="{{ $action }}" method="POST">
                    <!--inserir a variável do php-->
                    @csrf
                    <!--formulario submetido faça a verificação se houver um formulário de um sistema externo, para bloquear-->

                    @if(!empty($dado->id))
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <input type="hidden" name="id" value="{{$dado->id ?? '' }}">
                        <!--fazer as altrações do laragon. quando for salvar os dados do formulário após validação e mantem os dados do formulário caso algum erro-->

                        {{-- CORREÇÃO: os campos eram título/sinopse/ano/classificação/poster (cópia do form de filme).
                             O controller valida name, email e assinaturaestado_id, por isso "nome obrigatório" sempre falhava --}}
                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700">Nome</label>
                            <input type="text" id="name"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                name="name" value="{{ old('name', $dado->name ?? '') }}">
                        </div>

                        <div>
                            <label for="email" class="block font-medium text-sm text-gray-700">E-mail</label>
                            <input type="email" id="email"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                name="email" value="{{ old('email', $dado->email ?? '') }}">
                        </div>

                        {{-- senha só no cadastro (o storeUser exige; o updateUser não altera senha) --}}
                        @empty($dado->id)
                            <div>
                                <label for="password" class="block font-medium text-sm text-gray-700">Senha</label>
                                <input type="password" id="password"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                    name="password">
                            </div>
                        @endempty

                        {{-- CORREÇÃO: o select estava vazio e com name="genero_filme". Agora é o select do relacionamento 1:1
                             (User -> AssinaturaEstado), mostrando código e status em vez do ID --}}
                        <div>
                            <label for="assinaturaestado_id" class="block font-medium text-sm text-gray-700">Assinatura</label>
                            <select name="assinaturaestado_id" id="assinaturaestado_id"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                <option value="">Sem assinatura</option>
                                @foreach($assinaturas as $a)
                                    <option value="{{ $a->id }}" {{ old('assinaturaestado_id', $dado->assinaturaestado_id ?? '') == $a->id ? 'selected' : '' }}>
                                        {{ $a->codigo_transacao }} ({{ $a->status }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- CORREÇÃO: checkbox de admin. O controller usa $request->boolean('is_admin').
                             old() sem argumento só tem conteúdo depois de um erro de validação; nesse caso vale o que o admin marcou --}}
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="is_admin" name="is_admin" value="1"
                                {{ (old() ? old('is_admin') : ($dado->is_admin ?? false)) ? 'checked' : '' }}>
                            <label for="is_admin" class="font-medium text-sm text-gray-700">Administrador</label>
                        </div>
                    </div>

                    {{-- CORREÇÃO: o bloco do poster (img com "/storage/ {{ }}" com espaço + input file) foi removido, pois não é deste form --}}

                    <div class="flex items-center gap-2 mt-4">
                        <button type="submit" style="background-color: #16a34a; color: #ffffff;"
                            class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Salvar
                        </button>

                        {{-- CORREÇÃO: url('usersadmin') não existe. A rota da listagem é users.list --}}
                        <a href="{{ route('users.list') }}"
                            class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Voltar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>