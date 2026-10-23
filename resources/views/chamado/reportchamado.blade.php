<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #222222; }
        h1 { font-size: 20px; color: #4c32a8; margin: 0 0 4px 0; }
        .subtitulo { color: #666666; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #4c32a8; color: #ffffff; text-align: left; padding: 6px; font-size: 11px; }
        td { border-bottom: 1px solid #cccccc; padding: 5px 6px; vertical-align: top; }
        .rodape { margin-top: 14px; color: #666666; }
    </style>
</head>

<body>

    <h1>{{ $title }}</h1>

    <p class="subtitulo">Gerado em: {{ $date }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Criado em</th>
                <th>Encerrado em</th>
                <th>Usuário</th>
            </tr>
        </thead>
        <tbody>
            @forelse($chamados as $chamado)
                <tr>
                    <td>{{ $chamado->id }}</td>
                    <td>{{ $chamado->titulo }}</td>
                    <td>{{ $chamado->descricao }}</td>
                    <td>{{ $chamado->status }}</td>
                    <td>{{ $chamado->data_criacao?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td>{{ $chamado->data_encerramento?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td>{{ $chamado->user->name ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Nenhum chamado encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="rodape">Total de chamados: {{ $chamados->count() }}</p>

</body>

</html>