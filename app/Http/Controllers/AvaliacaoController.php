<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Avaliacao;

class AvaliacaoController extends Controller
{
    public function index()
{
    return view('avaliacao.listavaliacao', compact('dados'));
}


    public function create(Request $request)
    {
        $catalogo_id = $request->catalogo_id; // pega o id que o botão do catalogo deu

        return view('avaliacao.formavaliacao', compact('catalogo_id')); // retorna o form + id do botao
    }

    public function store(Request $request)
    {
        $request->validate([
            'nota' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:500',
            'spoiler' => 'boolean',
        ]);

        Avaliacao::create($request->all());
        return redirect('avaliacao')->with('success', 'Cadastro realizado com sucesso!');
    }

    public function edit($id)
    {
        $dado = Avaliacao::findOrFail($id);
        return view('avaliacao.formavaliacao', compact('dado'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nota' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:500',
            'spoiler' => 'boolean',
        ]);
        $dado = Avaliacao::findOrFail($id);
        $dado->update($request->only(['nota', 'comentario', 'spoiler']));

        return redirect('avaliacao')->with('success', 'Registro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        Avaliacao::destroy($id);
        return redirect('avaliacao')->with('success', 'Registro removido com sucesso!');
    }

    public function search(Request $request)
{
    if (!empty($request->valor)) {
        $dados = Avaliacao::with('catalogo')
            ->where($request->tipo, 'like', '%' . $request->valor . '%')
            ->get();
    } else {
        $dados = Avaliacao::with('catalogo')->get();
    }

    return view('avaliacao.listavaliacao', compact('dados'));
}
}