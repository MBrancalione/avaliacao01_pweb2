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
            @yield('conteudo')
        </div>
    </main>
</body>
</html>