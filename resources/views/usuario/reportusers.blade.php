<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>

    {{-- O DomPDF não carrega CSS externo, então o estilo fica aqui dentro.
         DejaVu Sans já vem com o DomPDF e garante os acentos em português --}}
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #222222; }
        h1 { font-size: 20px; color: #4c32a8; margin: 0 0 4px 0; }
        .subtitulo { color: #666666; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #4c32a8; color: #ffffff; text-align: left; padding: 6px; font-size: 11px; }
        td { border-bottom: 1px solid #cccccc; padding: 5px 6px; vertical-align: top; }
        tr.zebra td { background-color: #f8f6fe; }
        .selo { font-weight: bold; color: #4c32a8; }
        .vazio { color: #999999; }
        .resumo { margin-top: 14px; color: #444444; }
        .resumo span { margin-right: 18px; }
        .rodape { margin-top: 14px; color: #666666; }
    </style>
</head>

<body>

    <h1>{{ $title }}</h1>

    <p class="subtitulo">Gerado em: {{ $date }}</p>

    {{-- As colunas batem com os campos do usuário; o plano e o estado da assinatura vêm do relacionamento
         User -> AssinaturaEstado (o controller carrega com with('assinaturaEstado.plano')) --}}
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Tipo</th>
                <th>Plano</th>
                <th>Estado da Assinatura</th>
                <th>Cód. Transação</th>
                <th>Cadastrado em</th>
            </tr>
        </thead>
        <tbody>
            @forelse($usuarios as $usuario)
                <tr class="{{ $loop->even ? 'zebra' : '' }}">
                    <td>{{ $usuario->id }}</td>
                    <td><span class="selo">{{ $usuario->name }}</span></td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->is_admin ? 'Administrador' : 'Usuário' }}</td>
                    <td>{{ $usuario->assinaturaEstado->plano->nome_plano ?? '-' }}</td>
                    <td>{{ $usuario->assinaturaEstado->status ?? 'Sem Assinatura' }}</td>
                    <td>{{ $usuario->assinaturaEstado->codigo_transacao ?? '-' }}</td>
                    {{-- created_at é Carbon por padrão no model --}}
                    <td>{{ $usuario->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Nenhum usuário encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="resumo">
        <span>Administradores: {{ $usuarios->where('is_admin', true)->count() }}</span>
        <span>Com assinatura: {{ $usuarios->filter(fn($u) => $u->assinaturaEstado)->count() }}</span>
        <span>Sem assinatura: {{ $usuarios->filter(fn($u) => !$u->assinaturaEstado)->count() }}</span>
    </p>

    <p class="rodape">Total de usuários: {{ $usuarios->count() }}</p>

</body>

</html>
