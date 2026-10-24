<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #4c32a8;">
            {{ __('Gráfico de Notas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="gb-wrap">
            <div class="gb-box">

                <h3 class="gb-title">{{ $filme->titulo }}</h3>

                <p class="gb-genre">
                    <span class="gb-chip">{{ $filme->GeneroFilme->genero_filme ?? 'Gênero não especificado' }}</span>
                </p>

                <div class="gb-synopsis">
                    <strong>Sinopse</strong>
                    {{ $filme->sinopse }}
                </div>

                <h4 class="gb-section">Gráfico de Notas</h4>
                <div class="gb-stats">
                    <div class="gb-stat">
                        <span class="gb-stat-label">Total de avaliações</span>
                        <span class="gb-stat-value">{{ $total }}</span>
                    </div>
                    <div class="gb-stat">
                        <span class="gb-stat-label">Nota média</span>
                        <span class="gb-stat-value">{{ $media ? number_format($media, 1, ',', '.') : '-' }}</span>
                    </div>
                </div>

                <div class="gb-chart">
                    {!! $chart->container() !!}
                </div>
                @php $admin = auth()->user()->is_admin; @endphp
                <a href="{{ $admin ? route('filmeadmin') : route('filmeuser') }}" class="gb-btn">
                    &larr; {{ $admin ? 'Voltar à listagem' : 'Voltar ao catálogo' }}
                </a>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    {!! $chart->script() !!}
</x-app-layout>