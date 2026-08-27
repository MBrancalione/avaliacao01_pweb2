@extends('main')
@section('titulo', 'Formulário de Avaliacao')
@section('conteudo')
<div class="row">
    @php
        if (!empty($data->id)) {
            $action = route('avaliacao.update', $data->id);
        } else {
            $action = route('avaliacao.store');
        }
    @endphp

    <h4>Formulário Avaliação</h4>
    <form action="{{ $action }}" method="post">
        @csrf
        @if (!empty($data->id))
            @method('PUT')
        @endif

        <input type="hidden" name="id" value="{{ old('id', $data->id ?? '') }}">
        <div class="col-6">
            <label for="nota">Nota</label>
            <input type="text" name="nota" class="form-control" value="{{ old('nota', $data->nome_plano ?? '') }}">
            <option value="" style="color: #000;">Escolha uma nota...</option>
            <?php 
                                    $opcoesNotas = [
                                        "5" => "★★★★★ (5 - Excelente)",
                                        "4" => "★★★★☆ (4 - Muito Bom)",
                                        "3" => "★★★☆☆ (3 - Regular)",
                                        "2" => "★★☆☆☆ (2 - Ruim)",
                                        "1" => "★☆☆☆☆ (1 - Péssimo)"
                                    ];
                                    foreach ($opcoesNotas as $valor => $texto):
                                        $selected = ($notaAtual == $valor) ? 'selected' : '';
                                        echo "<option value='{$valor}' {$selected} style='color: #212529;'>{$texto}</option>";
                                    endforeach;
                                    ?>
        </div>
        <div class="col-6">
            <label for="preco_mensal">Comentario</label>
            <input type="text" name="comentario" class="form-control"
                value="{{ old('comentario', $data->comentario ?? '') }}">
        </div>
        <div class="col-6">
            <label for="spoiler">Spoiler</label>
            <input type="bool" name="spoiler" class="form-control"
                value="{{ old('spoiler', $data->spoiler ?? '') }}">
            <option value="1" <?= ($spoiler == '1' || $spoiler == 'Sim') ? 'selected' : '' ?>>Sim</option>
            <option value="0" <?= ($spoiler == '0' || $spoiler == 'Não') ? 'selected' : '' ?>>Não</option>
        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ url('avaliacao') }}" class="btn btn-primary"> Voltar</a>
        </div>
    </form>
</div>
@stop