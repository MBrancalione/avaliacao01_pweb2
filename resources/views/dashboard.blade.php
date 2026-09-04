<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="shrink-0 flex items-center">
                <a href="{{ route('main') }}" class="font-bold text-xl text-gray-800">
                    BIBI TV
                </a>
            </div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Olá, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-gray-600 text-sm">Bem-vindo ao painel de administração da sua plataforma.</p>
                </div>
                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Painel
                    Ativo</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <div
                    class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500 flex justify-between items-center">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total no Catálogo</p>
                        <p class="text-2xl font-bold text-gray-800">10</p>
                    </div>
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-full">
                        🎬
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500 flex justify-between items-center">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Planos Ativos</p>
                        <p class="text-2xl font-bold text-gray-800">3</p>
                    </div>
                    <div class="p-3 bg-green-50 text-green-600 rounded-full">
                        💳
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-indigo-500 flex justify-between items-center">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Usuários</p>
                        <p class="text-2xl font-bold text-gray-800">5</p>
                    </div>
                    <div class="p-3 bg-indigo-50 text-indigo-600 rounded-full">
                        👥
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-yellow-500 flex justify-between items-center">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Avaliações</p>
                        <p class="text-2xl font-bold text-gray-800">5</p>
                    </div>
                    <div class="p-3 bg-yellow-50 text-yellow-600 rounded-full">
                        ⭐
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>