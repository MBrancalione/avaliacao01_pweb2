<section>
    <style>
        /* Mesmo visual roxo do Profile Information, sem depender do Tailwind compilado */
        .pw-title { color: #4c32a8; font-size: 18px; font-weight: 700; margin: 0 0 4px; }
        .pw-sub   { color: #4b5563; font-size: 14px; margin: 0 0 20px; }

        .pw-form  { display: grid; grid-template-columns: 1fr; gap: 18px; }
        .pw-label { display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #374151; }
        .pw-input {
            width: 100%; box-sizing: border-box; padding: 10px 12px; font-size: 14px; color: #111827; background: #fff;
            border: 1px solid #d1d5db; border-radius: 10px; box-shadow: 0 1px 2px rgba(0,0,0,.04);
            transition: border-color .15s ease, box-shadow .15s ease; color-scheme: light;
        }
        .pw-input:focus { outline: none; border-color: #4c32a8; box-shadow: 0 0 0 3px rgba(76,50,168,.18); }

        .pw-error { margin: 6px 0 0; font-size: 13px; color: #991b1b; }

        .pw-actions { display: flex; align-items: center; gap: 14px; margin-top: 8px; padding-top: 22px; border-top: 1px solid #f0edf9; }
        .pw-btn {
            display: inline-flex; align-items: center; padding: 10px 22px; border-radius: 10px; cursor: pointer;
            background: #4c32a8; color: #fff; border: 1px solid transparent;
            font-family: inherit; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; line-height: 1;
            transition: opacity .15s ease;
        }
        .pw-btn:hover { opacity: .9; }
        .pw-saved { font-size: 14px; font-weight: 600; color: #4c32a8; margin: 0; }
    </style>

    <header>
        <h2 class="pw-title">{{ __('Update Password') }}</h2>
        <p class="pw-sub">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="pw-form">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="pw-label">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="pw-input" autocomplete="current-password">
            @foreach ($errors->updatePassword->get('current_password') as $message)
                <p class="pw-error">{{ $message }}</p>
            @endforeach
        </div>

        <div>
            <label for="update_password_password" class="pw-label">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" class="pw-input" autocomplete="new-password">
            @foreach ($errors->updatePassword->get('password') as $message)
                <p class="pw-error">{{ $message }}</p>
            @endforeach
        </div>

        <div>
            <label for="update_password_password_confirmation" class="pw-label">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="pw-input" autocomplete="new-password">
            @foreach ($errors->updatePassword->get('password_confirmation') as $message)
                <p class="pw-error">{{ $message }}</p>
            @endforeach
        </div>

        <div class="pw-actions">
            <button type="submit" class="pw-btn">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="pw-saved"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>