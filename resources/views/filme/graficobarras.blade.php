<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- CORREÇÃO: era $catalogo->titulo. O model Catalogo não existe mais, a variável agora é $filme --}}
    <title>{{ $filme->titulo }}</title>
</head>
<body>
    <div style="padding: 20px;">
        <h1>{{ $filme->titulo }}</h1>
        {{-- CORREÇÃO: era $catalogo->genero. Agora vem pelo relacionamento Filme -> GeneroFilme --}}
        <p><strong>Gênero:</strong> {{ $filme->GeneroFilme->genero_filme ?? 'Gênero não especificado' }}</p>
        <p><strong>Sinopse:</strong> {{ $filme->sinopse }}</p>

        <hr>

        <h2>Gráfico de Notas</h2>
        {{-- CORREÇÃO: resumo ao lado do gráfico --}}
        <p>Total de avaliações: {{ $total }} | Nota média: {{ $media ? number_format($media, 1, ',', '.') : '-' }}</p>
        <div style="width: 100%; max-width: 650px;">
            {!! $chart->container() !!}
        </div>

        {{-- CORREÇÃO: link de volta (o filme é aberto pelo catálogo do usuário) --}}
        <p style="margin-top: 20px;"><a href="{{ url('filmeuser') }}">&larr; Voltar ao catálogo</a></p>
    </div>

    <!-- CDN do ApexCharts (Obrigatório para o Larapex funcionar) -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Scripts gerados pelo Larapex -->
    {!! $chart->script() !!}
</body>
</html>