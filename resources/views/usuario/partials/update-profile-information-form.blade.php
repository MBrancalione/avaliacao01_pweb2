<section>
    <style>
        /* Cartão de perfil */
        .pi-card   { display: flex; align-items: center; gap: 20px; padding: 20px; margin-bottom: 28px;
                     background: linear-gradient(135deg, #ede9f9 0%, #f8f6fe 100%); border: 1px solid #e0d9f5; border-radius: 16px; }
        .pi-avatar { flex-shrink: 0; width: 96px; height: 96px; border-radius: 999px; object-fit: cover;
                     border: 4px solid #fff; box-shadow: 0 4px 14px rgba(76,50,168,.25); }
        .pi-initial { display: flex; align-items: center; justify-content: center; background: #4c32a8; color: #fff;
                      font-size: 38px; font-weight: 700; }
        .pi-info   { min-width: 0; }
        .pi-name   { margin: 0; font-size: 22px; font-weight: 700; color: #4c32a8; overflow: hidden; text-overflow: ellipsis; }
        .pi-email  { margin: 2px 0 10px; font-size: 14px; color: #4b5563; overflow: hidden; text-overflow: ellipsis; }
        .pi-plan   { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 999px;
                     background: #4c32a8; color: #fff; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; }
        .pi-plan-none { background: #fff; color: #6b7280; border: 1px solid #d1d5db; }
        @media (max-width: 480px) { .pi-card { flex-direction: column; text-align: center; } }

        /* Formulário */
        .pi-title { color: #4c32a8; font-size: 18px; font-weight: 700; margin: 0 0 4px; }
        .pi-sub   { color: #4b5563; font-size: 14px; margin: 0 0 20px; }

        .pi-form  { display: grid; grid-template-columns: 1fr; gap: 18px; }
        .pi-label { display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151; }
        .pi-input {
            width: 100%; box-sizing: border-box; padding: 10px 12px; font-size: 14px; color: #111827; background: #fff;
            border: 1px solid #d1d5db; border-radius: 10px; box-shadow: 0 1px 2px rgba(0,0,0,.04);
            transition: border-color .15s ease, box-shadow .15s ease; color-scheme: light;
        }
        .pi-input:focus { outline: none; border-color: #4c32a8; box-shadow: 0 0 0 3px rgba(76,50,168,.18); }
        .pi-file { padding: 8px 12px; cursor: pointer; }

        /* Divisória e Layouts do Endereço */
        .pi-section-title { font-size: 16px; font-weight: 700; color: #4c32a8; margin-top: 10px; padding-top: 16px; border-top: 1px dashed #e0d9f5; }
        .pi-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        .pi-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; }
        .pi-grid-cep { display: grid; grid-template-columns: 140px 1fr; gap: 18px; }

        @media (max-width: 640px) {
            .pi-grid-2, .pi-grid-3, .pi-grid-cep { grid-template-columns: 1fr; }
        }

        .pi-error  { margin: 6px 0 0; font-size: 13px; color: #991b1b; }
        .pi-warn   { margin-top: 8px; font-size: 14px; color: #374151; }
        .pi-link   { background: none; border: 0; padding: 0; cursor: pointer; font: inherit; font-size: 14px; color: #4c32a8; text-decoration: underline; }
        .pi-link:hover { opacity: .8; }
        .pi-ok     { margin-top: 8px; font-size: 14px; font-weight: 600; color: #16a34a; }

        .pi-actions { display: flex; align-items: center; gap: 14px; margin-top: 8px; padding-top: 22px; border-top: 1px solid #f0edf9; }
        .pi-btn {
            display: inline-flex; align-items: center; padding: 10px 22px; border-radius: 10px; cursor: pointer;
            background: #4c32a8; color: #fff; border: 1px solid transparent;
            font-family: inherit; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; line-height: 1;
            transition: opacity .15s ease;
        }
        .pi-btn:hover { opacity: .9; }
        .pi-saved { font-size: 14px; font-weight: 600; color: #4c32a8; margin: 0; }
    </style>

    {{-- Cartão de perfil: foto, nome, email e plano --}}
    <div class="pi-card">
        @if ($user->foto_perfil)
            <img src="{{ asset('storage/' . $user->foto_perfil) }}" alt="Foto de perfil" class="pi-avatar">
        @else
            <div class="pi-avatar pi-initial">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</div>
        @endif

        <div class="pi-info">
            <h3 class="pi-name">{{ $user->name }}</h3>
            <p class="pi-email">{{ $user->email }}</p>

            @if ($user->plano)
                <span class="pi-plan">Plano {{ $user->plano->nome_plano }}</span>
            @else
                <span class="pi-plan pi-plan-none">Sem plano</span>
            @endif
        </div>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('usuario.update') }}" class="pi-form" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Dados Pessoais --}}
        <div>
            <label for="name" class="pi-label">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="pi-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name') <p class="pi-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="pi-label">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="pi-input" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email') <p class="pi-error">{{ $message }}</p> @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="pi-warn">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="pi-link">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="pi-ok">{{ __('A new verification link has been sent to your email address.') }}</p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <label for="foto_perfil" class="pi-label">{{ __('Alterar foto de perfil') }}</label>
            <input id="foto_perfil" name="foto_perfil" type="file" class="pi-input pi-file">
            @error('foto_perfil') <p class="pi-error">{{ $message }}</p> @enderror
        </div>

        {{-- Seção de Endereço --}}
        <div class="pi-section-title">Endereço</div>

        <div class="pi-grid-cep">
            <div>
                <label for="cep" class="pi-label">CEP</label>
                <input id="cep" name="cep" type="text" class="pi-input" value="{{ old('cep', $user->cep) }}" placeholder="00000-000" maxlength="9">
                @error('cep') <p class="pi-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="logradouro" class="pi-label">Logradouro / Rua</label>
                <input id="logradouro" name="logradouro" type="text" class="pi-input" value="{{ old('logradouro', $user->logradouro) }}" placeholder="Rua, Avenida...">
                @error('logradouro') <p class="pi-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="pi-grid-2">
            <div>
                <label for="numero" class="pi-label">Número</label>
                <input id="numero" name="numero" type="text" class="pi-input" value="{{ old('numero', $user->numero) }}" placeholder="123">
                @error('numero') <p class="pi-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="complemento" class="pi-label">Complemento</label>
                <input id="complemento" name="complemento" type="text" class="pi-input" value="{{ old('complemento', $user->complemento) }}" placeholder="Apto, Bloco, etc.">
                @error('complemento') <p class="pi-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="pi-grid-3">
            <div>
                <label for="bairro" class="pi-label">Bairro</label>
                <input id="bairro" name="bairro" type="text" class="pi-input" value="{{ old('bairro', $user->bairro) }}">
                @error('bairro') <p class="pi-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="cidade" class="pi-label">Cidade</label>
                <input id="cidade" name="cidade" type="text" class="pi-input" value="{{ old('cidade', $user->cidade) }}">
                @error('cidade') <p class="pi-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="estado" class="pi-label">Estado (UF)</label>
                <input id="estado" name="estado" type="text" class="pi-input" value="{{ old('estado', $user->estado) }}" placeholder="EX: SP" maxlength="2">
                @error('estado') <p class="pi-error">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Ações --}}
        <div class="pi-actions">
            <button type="submit" class="pi-btn">{{ __('Save') }}</button>

            @if (session('status') === 'usuario-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="pi-saved"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    {{-- Auto-busca de CEP via ViaCEP --}}
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
</section>