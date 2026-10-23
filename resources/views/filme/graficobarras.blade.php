<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #4c32a8;">
            {{ __('Gráfico de Notas') }}
        </h2>
    </x-slot>

    <style>
        /* CSS próprio: mesmo visual roxo do site, sem depender do Tailwind compilado */
        .gb-wrap  { width: 100%; max-width: 1100px; margin: 0 auto; padding: 0 16px; box-sizing: border-box; }
        @media (min-width: 640px) { .gb-wrap { padding: 0 24px; } }

        .gb-box   { max-width: 860px; margin: 0 auto; background: #fff; border-radius: 16px; box-shadow: 0 4px 14px rgba(0,0,0,.1); padding: 32px; }

        /* Cabeçalho do filme */
        .gb-title { margin: 0 0 8px; text-align: center; color: #4c32a8; font-size: 28px; font-weight: 700; }
        .gb-chip  { display: inline-block; background: #ede9f9; color: #4c32a8; font-size: 12px; font-weight: 700; padding: 4px 12px; border-radius: 999px; }
        .gb-genre { margin: 0 0 18px; text-align: center; }
        .gb-synopsis { margin: 0 0 24px; padding: 16px 20px; border-radius: 14px; font-size: 14px; line-height: 1.6; color: #374151;
                       background: linear-gradient(135deg, #ede9f9 0%, #f8f6fe 100%); border: 1px solid #e0d9f5; }
        .gb-synopsis strong { display: block; margin-bottom: 4px; font-size: 12px; text-transform: uppercase; letter-spacing: .06em; color: #4c32a8; }

        .gb-section { margin: 0 0 16px; text-align: center; color: #4c32a8; font-size: 20px; font-weight: 700; padding-top: 22px; border-top: 1px solid #f0edf9; }

        /* Resumo */
        .gb-stats { display: grid; grid-template-columns: 1fr; gap: 14px; margin-bottom: 24px; }
        @media (min-width: 640px) { .gb-stats { grid-template-columns: 1fr 1fr; } }
        .gb-stat  { padding: 16px 20px; border-radius: 14px; text-align: center;
                    background: linear-gradient(135deg, #ede9f9 0%, #f8f6fe 100%); border: 1px solid #e0d9f5; }
        .gb-stat-label { display: block; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #6b7280; }
        .gb-stat-value { display: block; margin-top: 4px; font-size: 26px; font-weight: 700; color: #4c32a8; }

        .gb-chart { width: 100%; max-width: 650px; margin: 0 auto; }

        .gb-actions { display: flex; justify-content: center; gap: 10px; margin-top: 26px; padding-top: 22px; border-top: 1px solid #f0edf9; }
        .gb-btn {
            display: inline-flex; align-items: center; padding: 10px 22px; border-radius: 10px; cursor: pointer;
            background: #fff; color: #4c32a8; border: 1px solid #4c32a8;
            font-family: inherit; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em;
            text-decoration: none; line-height: 1; transition: background .15s ease;
        }
        .gb-btn:hover { background: #ede9f9; }
    </style>

    <div class="py-12">
        <div class="gb-wrap">
            <div class="gb-box">

                <h3 class="gb-title">{{ $filme->titulo }}</h3>

                {{-- Gênero vem pelo relacionamento Filme -> GeneroFilme --}}
                <p class="gb-genre">
                    <span class="gb-chip">{{ $filme->GeneroFilme->genero_filme ?? 'Gênero não especificado' }}</span>
                </p>

                <div class="gb-synopsis">
                    <strong>Sinopse</strong>
                    {{ $filme->sinopse }}
                </div>

                <h4 class="gb-section">Gráfico de Notas</h4>

                {{-- Resumo ao lado do gráfico --}}
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

                {{-- Link de volta (o filme é aberto pelo catálogo do usuário) --}}
                <div class="gb-actions">
                    <a href="{{ url('filmeuser') }}" class="gb-btn">&larr; Voltar ao catálogo</a>
                </div>

            </div>
        </div>
    </div>

    <!-- CDN do ApexCharts (Obrigatório para o Larapex funcionar) -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Scripts gerados pelo Larapex -->
    {!! $chart->script() !!}
</x-app-layout>