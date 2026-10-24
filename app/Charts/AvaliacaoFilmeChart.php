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
        $avaliacoes = Avaliacao::where('filme_id', $filmeId)
            ->select('nota', \DB::raw('count(*) as total'))
            ->groupBy('nota')
            ->get();

        $notas = [1, 2, 3, 4, 5];

        $votos = collect($notas)->map(function ($nota) use ($avaliacoes) {
            $registro = $avaliacoes->firstWhere('nota', $nota);
            return $registro ? (int) $registro->total : 0;
        })->all();

        return $this->chart->barChart()
            ->setTitle('Avaliações do Filme')
            ->setSubtitle('Distribuição de notas de 1 a 5')
            ->addData('Quantidade de Votos', $votos)
            ->setXAxis(array_map(fn($n) => "Nota $n", $notas));
    }
}