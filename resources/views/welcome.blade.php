<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body style="margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #0d0d12; color: #ffffff; min-height: 100vh; display: flex; flex-direction: column;">
    <div style="position: relative; flex: 1; display: flex; flex-direction: column; justify-content: space-between; background: radial-gradient(circle at center, rgba(126, 34, 206, 0.15) 0%, rgba(13, 13, 18, 0.95) 100%); padding: 20px;">
        <header style="width: 100%; max-width: 1200px; margin: 0 auto; display: flex; justify-content: flex-end; align-items: center; padding: 10px 0;">
            @if (Route::has('login'))
                <nav style="display: flex; gap: 15px;">
                    @auth
                        <a href="{{ url('login') }}" style="text-decoration: none; padding: 10px 24px; border-radius: 8px; font-size: 0.95rem; font-weight: 600; background-color: #7e22ce; color: #ffffff; transition: 0.2s;">Início</a>
                    @else
                        <a href="{{ route('login') }}" style="text-decoration: none; padding: 10px 24px; border-radius: 8px; font-size: 0.95rem; font-weight: 600; background-color: #7e22ce; color: #ffffff; transition: 0.2s;">Entrar</a>
                    @endauth
                </nav>
            @endif
        </header>

        <main style="max-w: 800px; margin: auto; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px 20px;">
            <h1 style="font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 800; line-height: 1.1; margin-bottom: 20px; color: #ffffff;">
                Filmes, séries e muito mais.
            </h1>
            
            <h2 style="font-size: clamp(1.2rem, 3vw, 1.75rem); font-weight: 400; color: #e9d5ff; margin-bottom: 24px;">
                Assista onde quiser. Cancele quando quiser.
            </h2>
            
            <p style="font-size: 1.1rem; color: #a855f7; margin-bottom: 32px;">
                Quer assistir? Clique abaixo para criar sua conta.
            </p>

            @if (Route::has('register'))
                <div>
                    <a href="{{ route('register') }}" style="display: inline-flex; align-items: center; gap: 10px; background-color: #7e22ce; color: #ffffff; padding: 16px 36px; font-size: 1.25rem; font-weight: 700; text-decoration: none; border-radius: 8px; box-shadow: 0 4px 20px rgba(126, 34, 206, 0.4);">
                        Criar Conta
                        <span style="font-size: 1.4rem; line-height: 1;">&rsaquo;</span>
                    </a>
                </div>
            @endif
        </main>

        <footer style="width: 100%; text-align: center; padding: 20px 0; font-size: 0.85rem; color: #6b21a8;">
            &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Todos os direitos reservados.
        </footer>

    </div>

</body>
</html>