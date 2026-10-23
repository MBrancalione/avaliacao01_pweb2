<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- CORREÇÃO: enctype="multipart/form-data" é obrigatório para enviar arquivo. Sem ele o controller nunca recebia a foto --}}
    <form method="post" action="{{ route('usuario.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- CORREÇÃO: campo de upload da foto (critério 4: mostra a imagem atual na edição).
             O UsuarioController::update já trata o arquivo e apaga a foto antiga --}}
        <div>
            <x-input-label for="foto_perfil" :value="__('Foto de perfil')" />
            @if ($user->foto_perfil)
                <img src="{{ asset('storage/' . $user->foto_perfil) }}" alt="Foto de perfil" class="mt-2 w-24 h-24 rounded-full object-cover">
            @endif
            <input id="foto_perfil" name="foto_perfil" type="file" class="mt-2 block w-full text-sm">
            <x-input-error class="mt-2" :messages="$errors->get('foto_perfil')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            {{-- CORREÇÃO: o controller devolve 'usuario-updated'. Comparava com 'profile-updated' e o "Saved." nunca aparecia --}}
            @if (session('status') === 'usuario-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>