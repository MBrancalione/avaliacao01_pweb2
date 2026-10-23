<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Divisor de Endereço -->
        <div class="mt-6 pt-4 border-t border-gray-200">
            <h3 class="font-semibold text-sm text-gray-700">Endereço</h3>
        </div>

        <!-- CEP & Logradouro -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
            <div>
                <x-input-label for="cep" :value="__('CEP')" />
                <x-text-input id="cep" class="block mt-1 w-full" type="text" name="cep" :value="old('cep')" placeholder="00000-000" maxlength="9" />
                <x-input-error :messages="$errors->get('cep')" class="mt-2" />
            </div>

            <div class="md:col-span-2">
                <x-input-label for="logradouro" :value="__('Logradouro / Rua')" />
                <x-text-input id="logradouro" class="block mt-1 w-full" type="text" name="logradouro" :value="old('logradouro')" placeholder="Rua, Avenida..." />
                <x-input-error :messages="$errors->get('logradouro')" class="mt-2" />
            </div>
        </div>

        <!-- Número & Complemento -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <x-input-label for="numero" :value="__('Número')" />
                <x-text-input id="numero" class="block mt-1 w-full" type="text" name="numero" :value="old('numero')" placeholder="123" />
                <x-input-error :messages="$errors->get('numero')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="complemento" :value="__('Complemento')" />
                <x-text-input id="complemento" class="block mt-1 w-full" type="text" name="complemento" :value="old('complemento')" placeholder="Apto, Bloco, etc." />
                <x-input-error :messages="$errors->get('complemento')" class="mt-2" />
            </div>
        </div>

        <!-- Bairro, Cidade & Estado -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div>
                <x-input-label for="bairro" :value="__('Bairro')" />
                <x-text-input id="bairro" class="block mt-1 w-full" type="text" name="bairro" :value="old('bairro')" />
                <x-input-error :messages="$errors->get('bairro')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="cidade" :value="__('Cidade')" />
                <x-text-input id="cidade" class="block mt-1 w-full" type="text" name="cidade" :value="old('cidade')" />
                <x-input-error :messages="$errors->get('cidade')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="estado" :value="__('UF')" />
                <x-text-input id="estado" class="block mt-1 w-full" type="text" name="estado" :value="old('estado')" placeholder="EX: SP" maxlength="2" />
                <x-input-error :messages="$errors->get('estado')" class="mt-2" />
            </div>
        </div>

        <!-- Password -->
        <div class="mt-6 pt-4 border-t border-gray-200">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    {{-- Script para busca automática do CEP --}}
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
</x-guest-layout>