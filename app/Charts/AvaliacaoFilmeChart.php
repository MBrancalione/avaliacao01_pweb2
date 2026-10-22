<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Avaliacao;

class AvaliacaoFilmeChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($filmeId): \ArielMejiaDev\LarapexCharts\BarChart
    {
        // Garante que o ID do filme seja um número inteiro
        $filmeId = (int) $filmeId;

        // Busca as avaliações no banco
        $avaliacoes = Avaliacao::where('filme_id', $filmeId)
            ->select('nota', \DB::raw('count(*) as total'))
            ->groupBy('nota')
            ->pluck('total', 'nota')
            ->toArray();

        // Cria o array estrito de 0 a 5 com inteiros puros
        $votos = [];
        for ($i = 0; $i <= 5; $i++) {
            $votos[$i] = isset($avaliacoes[$i]) ? (int) $avaliacoes[$i] : 0;
        }

        return $this->chart->barChart()
            ->setTitle('Avaliações do Filme')
            ->setSubtitle('Distribuição de notas de 0 a 5')
            ->addData([$votos[0], $votos[1], $votos[2], $votos[3], $votos[4], $votos[5]], 'Quantidade de Votos')
            ->setXAxis(['Nota 0', 'Nota 1', 'Nota 2', 'Nota 3', 'Nota 4', 'Nota 5']);
    }
}
