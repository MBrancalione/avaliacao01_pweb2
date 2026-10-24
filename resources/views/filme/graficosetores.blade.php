<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #4c32a8;">
            {{ __('Gráficos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="gb-wrap">
            <div class="gb-box">

                <h3 class="gb-title">Filmes por gênero</h3>
                <p class="gb-sub">Quantidade de filmes cadastrados em cada gênero.</p>

                @isset($totalFilmes)
                    <div class="gb-stats">
                        <div class="gb-stat">
                            <span class="gb-stat-label">Total de filmes</span>
                            <span class="gb-stat-value">{{ $totalFilmes }}</span>
                        </div>
                        <div class="gb-stat">
                            <span class="gb-stat-label">Gêneros</span>
                            <span class="gb-stat-value">{{ $totalGeneros ?? '-' }}</span>
                        </div>
                    </div>
                @endisset

                <div class="gb-chart">
                    {!! $chart->container() !!}
                </div>

                <div class="gb-actions">
                    <a href="{{ url('dashboard') }}" class="gb-btn">&larr; Voltar</a>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    {!! $chart->script() !!}
</x-app-layout>