<?php

namespace App\Charts;

use App\Models\Filme;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use ArielMejiaDev\LarapexCharts\PieChart;

class FilmesPorGeneroChart
{
    protected LarapexChart $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): PieChart
    {
        $contagem = Filme::with(['GeneroFilme'])
            ->get()
            ->groupBy(fn ($filme) => $filme->GeneroFilme->genero_filme ?? $filme->generoFilme->genero_filme ?? 'Sem gênero')
            ->map(fn ($filmes) => $filmes->count())
            ->sortDesc();

        if ($contagem->isEmpty()) {
            $dados  = [0];
            $labels = ['Nenhum filme cadastrado'];
        } else {
            $dados  = $contagem->values()->all();
            $labels = $contagem->keys()->all();
        }

        $paleta = ['#4c32a8', '#8b6fe0', '#a78bfa', '#6d4fd1', '#c4b5fd', '#24145c', '#7c3aed', '#ddd6fe'];
        $cores  = [];
        foreach ($labels as $i => $label) {
            $cores[] = $paleta[$i % count($paleta)];
        }

        return $this->chart->pieChart()
            ->setTitle('Filmes por gênero')
            ->setSubtitle('Quantidade de filmes cadastrados em cada gênero.')
            ->addData($dados)
            ->setLabels($labels)
            ->setColors($cores);
    }
}