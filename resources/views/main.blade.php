<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Aplicação')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* CSS próprio: funciona mesmo sem recompilar o Tailwind */

        /* Espaço lateral no celular (antes o conteúdo encostava na borda da tela) */
        .bibi-container { padding-left: 16px; padding-right: 16px; }
        @media (min-width: 640px)  { .bibi-container { padding-left: 24px; padding-right: 24px; } }
        @media (min-width: 1024px) { .bibi-container { padding-left: 32px; padding-right: 32px; } }

        /* Card de boas-vindas */
        .bibi-welcome { border-radius: 16px; box-shadow: 0 4px 14px rgba(76, 50, 168, .12); }
        .bibi-welcome h2 { color: #4c32a8; }

        /* Alertas (as classes eram do Bootstrap, que não está carregado neste layout) */
        main .alert {
            position: relative; padding: 14px 44px 14px 16px; margin-bottom: 16px;
            border: 1px solid transparent; border-radius: 12px; font-size: 14px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
        }
        main .alert-success { background: #ecfdf5; color: #065f46; border-color: #a7f3d0; }
        main .alert-danger  { background: #fef2f2; color: #991b1b; border-color: #fecaca; }
        main .alert ul { margin: 6px 0 0 18px; padding: 0; list-style: disc; }
        main .alert .btn-close {
            position: absolute; top: 10px; right: 12px; width: 24px; height: 24px;
            background: none; border: 0; cursor: pointer; opacity: .6; color: inherit;
        }
        main .alert .btn-close::before { content: "\00d7"; font-size: 22px; line-height: 24px; }
        main .alert .btn-close:hover { opacity: 1; }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100 min-h-screen">
    {{-- O menu fica fixo no topo: o sticky precisa estar no elemento que envolve a barra --}}
    <div style="position: sticky; top: 0; z-index: 50;">
        {{-- CORREÇÃO: admin vê o menu do admin (Catálogo = filmeadmin, Planos, Usuários, Chamados); usuário comum continua com o sidebar --}}
        @if(Auth::check() && Auth::user()->is_admin)
            @include('layouts.navigation') {{-- ajuste o caminho se o seu navigation.blade.php estiver em outra pasta --}}
        @else
            @include('sidebar') <!--serve para reservar o espaço para o que será inserido aqui-->
        @endif
    </div>

    <main class="py-12">
        <div class="max-w-7xl mx-auto bibi-container">

            @auth
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6 border-l-4 border-purple-600 bibi-welcome">
                    <h2 class="text-2xl font-bold text-gray-800">
                        Bem-vindo(a), {{ Auth::user()->name }}! 👋
                    </h2>
                    <p class="text-gray-600 mt-1">
                        Você está autenticado no sistema. O que planeja assistir hoje?
                    </p>
                </div> {{-- esta div estava sem fechar: todo o conteúdo ficava dentro do card de boas-vindas --}}
            @endauth

            <div class="col-12 col-md-9">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button class="btn-close" data-bs-dismiss="alert" aria-label="fechar" onclick="this.closest('.alert').remove()"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button class="btn-close" data-bs-dismiss="alert" aria-label="fechar" onclick="this.closest('.alert').remove()"></button>
                    </div>
                @endif
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <b>Por favor, verifique os erros abaixo</b>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('conteudo')
        </div>
    </main>
</body>

</html>
