<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-center" style="color: #4c32a8;">
            {{-- CORREÇÃO: era "Formulário Catálogo" (copiado do form de filme) --}}
            {{ __('Formulário Usuário') }}
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

        /* Checkbox de administrador (cartão clicável) */
        .fm-check {
            display: flex; align-items: center; gap: 12px; padding: 12px 14px; cursor: pointer;
            background: #f8f6fe; border: 1px solid #ede9f9; border-radius: 10px;
            transition: border-color .15s ease, background .15s ease;
        }
        .fm-check:hover { border-color: #c4b5fd; background: #f3f0fd; }
        .fm-check input { width: 18px; height: 18px; accent-color: #4c32a8; cursor: pointer; flex-shrink: 0; }
        .fm-check-title { font-size: 14px; font-weight: 700; color: #4c32a8; }
        .fm-check-desc  { font-size: 12px; color: #6b7280; }

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

                <h4 class="text-center" style="color: #4c32a8; font-size: 28px; font-weight: 700; margin: 0 0 4px;">Formulário Usuário</h4>
                <p class="text-center text-gray-600" style="margin: 0 0 24px;">Preencha os dados do usuário.</p>

                {{-- CORREÇÃO: o bloco de erros estava FORA do <x-app-layout> e aparecia acima do menu. Agora fica dentro do card --}}
                @if ($errors->any())
                    <div class="fm-errors">
                        <ul>
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

                {{-- CORREÇÃO: sem enctype, porque este form não tem upload (a foto o próprio usuário envia no perfil) --}}
                <form action="{{ $action }}" method="POST">
                    <!--inserir a variável do php-->
                    @csrf
                    <!--formulario submetido faça a verificação se houver um formulário de um sistema externo, para bloquear-->

                    @if(!empty($dado->id))
                        @method('PUT')
                    @endif

                    <div class="fm-grid">
                        <input type="hidden" name="id" value="{{$dado->id ?? '' }}">
                        <!--fazer as altrações do laragon. quando for salvar os dados do formulário após validação e mantem os dados do formulário caso algum erro-->

                        {{-- CORREÇÃO: os campos eram título/sinopse/ano/classificação/poster (cópia do form de filme).
                             O controller valida name, email e assinaturaestado_id, por isso "nome obrigatório" sempre falhava --}}
                        <div>
                            <label for="name" class="fm-label">Nome</label>
                            <input type="text" id="name" class="fm-input"
                                name="name" value="{{ old('name', $dado->name ?? '') }}">
                        </div>

                        <div>
                            <label for="email" class="fm-label">E-mail</label>
                            <input type="email" id="email" class="fm-input"
                                name="email" value="{{ old('email', $dado->email ?? '') }}">
                        </div>

                        {{-- senha só no cadastro (o storeUser exige; o updateUser não altera senha) --}}
                        @empty($dado->id)
                            <div>
                                <label for="password" class="fm-label">Senha</label>
                                <input type="password" id="password" class="fm-input"
                                    name="password">
                            </div>
                        @endempty

                        {{-- CORREÇÃO: o select estava vazio e com name="genero_filme". Agora é o select do relacionamento 1:1
                             (User -> AssinaturaEstado), mostrando código e status em vez do ID --}}
                        <div>
                            <label for="assinaturaestado_id" class="fm-label">Assinatura</label>
                            <select name="assinaturaestado_id" id="assinaturaestado_id" class="fm-input">
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
                        <div class="fm-span">
                            <label for="is_admin" class="fm-check">
                                <input type="checkbox" id="is_admin" name="is_admin" value="1"
                                    {{ (old() ? old('is_admin') : ($dado->is_admin ?? false)) ? 'checked' : '' }}>
                                <span>
                                    <span class="fm-check-title">Administrador</span><br>
                                    <span class="fm-check-desc">Dá acesso ao painel de administração da plataforma.</span>
                                </span>
                            </label>
                        </div>
                    </div>

                    {{-- CORREÇÃO: o bloco do poster (img com "/storage/ {{ }}" com espaço + input file) foi removido, pois não é deste form --}}

                    <div class="fm-actions">
                        <button type="submit" class="fm-btn fm-btn-primary">
                            Salvar
                        </button>

                        {{-- CORREÇÃO: url('usersadmin') não existe. A rota da listagem é users.list --}}
                        <a href="{{ route('users.list') }}" class="fm-btn fm-btn-ghost">
                            Voltar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
