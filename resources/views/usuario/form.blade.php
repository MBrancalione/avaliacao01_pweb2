<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-center" style="color: #4c32a8;">
            {{ __('Formulário Usuário') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="cat-wrap cat-pad">
            <div class="fm-box">

                <h4 class="text-center" style="color: #4c32a8; font-size: 28px; font-weight: 700; margin: 0 0 4px;">Formulário Usuário</h4>
                <p class="text-center text-gray-600" style="margin: 0 0 24px;">Preencha os dados do usuário.</p>

                @if ($errors->any())
                    <div class="fm-errors">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @php
                    if (!empty($dado->id)) {
                        $action = route('users.update', $dado->id);
                    } else {
                        $action = route('users.store');
                    }
                @endphp

                <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @if(!empty($dado->id))
                        @method('PUT')
                    @endif

                    <input type="hidden" name="id" value="{{ $dado->id ?? '' }}">

                    {{-- Dados Pessoais e Acesso --}}
                    <div class="fm-grid">
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

                        @empty($dado->id)
                            <div>
                                <label for="password" class="fm-label">Senha</label>
                                <input type="password" id="password" class="fm-input"
                                    name="password">
                            </div>
                        @endempty

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
                        <div class="fm-span">
    <label for="foto_perfil" class="fm-label">Foto de perfil</label>
    @if(!empty($dado->foto_perfil))
        <img src="{{ $dado->url_foto }}" alt="Foto" class="pl-avatar" style="width:80px;height:80px;margin:0 0 10px;">
    @endif
    <input type="file" id="foto_perfil" name="foto_perfil" class="fm-input">
</div>  

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

                    {{-- Seção de Endereço --}}
                    <div class="fm-section-title">Endereço</div>

                    <div class="fm-grid-cep" style="margin-bottom: 18px;">
                        <div>
                            <label for="cep" class="fm-label">CEP</label>
                            <input type="text" id="cep" class="fm-input" name="cep"
                                value="{{ old('cep', $dado->cep ?? '') }}" placeholder="00000-000" maxlength="9">
                        </div>

                        <div>
                            <label for="logradouro" class="fm-label">Logradouro / Rua</label>
                            <input type="text" id="logradouro" class="fm-input" name="logradouro"
                                value="{{ old('logradouro', $dado->logradouro ?? '') }}" placeholder="Rua, Avenida...">
                        </div>
                    </div>

                    <div class="fm-grid" style="margin-bottom: 18px;">
                        <div>
                            <label for="numero" class="fm-label">Número</label>
                            <input type="text" id="numero" class="fm-input" name="numero"
                                value="{{ old('numero', $dado->numero ?? '') }}" placeholder="123">
                        </div>

                        <div>
                            <label for="complemento" class="fm-label">Complemento</label>
                            <input type="text" id="complemento" class="fm-input" name="complemento"
                                value="{{ old('complemento', $dado->complemento ?? '') }}" placeholder="Apto, Bloco, etc.">
                        </div>
                    </div>

                    <div class="fm-grid-3" style="margin-bottom: 22px;">
                        <div>
                            <label for="bairro" class="fm-label">Bairro</label>
                            <input type="text" id="bairro" class="fm-input" name="bairro"
                                value="{{ old('bairro', $dado->bairro ?? '') }}">
                        </div>

                        <div>
                            <label for="cidade" class="fm-label">Cidade</label>
                            <input type="text" id="cidade" class="fm-input" name="cidade"
                                value="{{ old('cidade', $dado->cidade ?? '') }}">
                        </div>

                        <div>
                            <label for="estado" class="fm-label">Estado (UF)</label>
                            <input type="text" id="estado" class="fm-input" name="estado"
                                value="{{ old('estado', $dado->estado ?? '') }}" placeholder="EX: SP" maxlength="2">
                        </div>
                    </div>

                    {{-- Ações --}}
                    <div class="fm-actions">
                        <button type="submit" class="fm-btn fm-btn-primary">
                            Salvar
                        </button>

                        <a href="{{ route('users.list') }}" class="fm-btn fm-btn-ghost">
                            Voltar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- Script de busca do CEP via ViaCEP --}}
    <script>
        document.getElementById('cep')?.addEventListener('blur', function () {
            let cep = this.value.replace(/\D/g, '');
            if (cep.length === 8) {
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(res => res.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('logradouro').value = data.logradouro || '';
                            document.getElementById('bairro').value = data.bairro || '';
                            document.getElementById('cidade').value = data.localidade || '';
                            document.getElementById('estado').value = data.uf || '';
                            document.getElementById('numero').focus();
                        }
                    });
            }
        });
    </script>
</x-app-layout>