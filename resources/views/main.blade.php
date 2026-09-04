<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Aplicação')</title>
    
    <!-- Scripts & Styles via Vite (Tailwind CSS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 min-h-screen">
    <!-- Sidebar / Topbar -->
    <div>
        @include('sidebar') <!--serve para reservar o espaço para o que será inserido aqui-->
        <!--tudo que estiver dentro de sidebar será iniciado aqui-->
    </div>

    <!-- Conteúdo da Página -->
    <main class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Mensagem de Boas-Vindas ao Fazer Login -->
            @auth
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6 border-l-4 border-purple-600">
                    <h2 class="text-2xl font-bold text-gray-800">
                        Bem-vindo(a), {{ Auth::user()->name }}! 👋
                    </h2>
                    <p class="text-gray-600 mt-1">
                        Você está autenticado no sistema. Escolha uma das opções abaixo para acessar rapidamente:
                    </p>

                    <!-- Cards de Atalho -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
                        
                        <!-- Card: Catálogo -->
                        <a href="{{ url('catalogouser') }}" class="p-4 bg-gray-50 border border-gray-200 rounded-lg hover:border-purple-600 hover:bg-purple-50 transition duration-150 flex flex-col items-center text-center group">
                            <div class="p-3 bg-purple-100 text-purple-600 rounded-full mb-2 group-hover:bg-purple-600 group-hover:text-white transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-800 group-hover:text-purple-600">Catálogo</span>
                        </a>

                        <!-- Card: Avaliação -->
                        <a href="{{ url('avaliacao') }}" class="p-4 bg-gray-50 border border-gray-200 rounded-lg hover:border-purple-600 hover:bg-purple-50 transition duration-150 flex flex-col items-center text-center group">
                            <div class="p-3 bg-purple-100 text-purple-600 rounded-full mb-2 group-hover:bg-purple-600 group-hover:text-white transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-800 group-hover:text-purple-600">Avaliação</span>
                        </a>


                    </div>
                </div>
            @endauth

            @yield('conteudo')
        </div>
    </main>
</body>
</html>