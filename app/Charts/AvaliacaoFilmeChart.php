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
        $avaliacoes = Avaliacao::where('filme_id', $filmeId)//utilizado para filtrar as avaliações de um filme específico
            ->select('nota', \DB::raw('count(*) as total')) //\DB::raw() é usado para executar uma expressão bruta no banco de dados
            ->groupBy('nota') 
            ->get(); 

        // armazena a contagem de votos para cada nota
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
