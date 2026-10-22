<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>{{ $catalogo->titulo }}</title>
</head>
<body>
    <div style="padding: 20px;">
        <h1>{{ $catalogo->titulo }}</h1>
        <p><strong>Gênero:</strong> {{ $catalogo->genero }}</p>
        <p><strong>Sinopse:</strong> {{ $catalogo->sinopse }}</p>

        <hr>

        <h2>Gráfico de Notas</h2>
        <div style="width: 100%; max-width: 650px;">
            {!! $chart->container() !!}
        </div>
    </div>

    <!-- CDN do ApexCharts (Obrigatório para o Larapex funcionar) -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    
    <!-- Scripts gerados pelo Larapex -->
    {!! $chart->script() !!}
</body>
</html>