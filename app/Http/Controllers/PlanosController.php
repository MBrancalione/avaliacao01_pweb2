<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planos;

class PlanosController extends Controller
{
    public function index()
    {
        $dados = Planos::all();
        return view('planos.listplanos', compact('dados'));
    }

    public function create()
    {
        return view('planos.formplanos');
    }

    public function store(Request $request)
    {
        $this->validateForm($request);

        Planos::create($request->all());
        return redirect('planos')->with('success', 'Cadastro realizado com sucesso!');
    }

    public function edit($id)
    {
        $dado = Planos::findOrFail($id);
        return view('planos.formplanos', compact('dado'));
    }

    public function destroy($id)
    {
        $plano = Planos::findOrFail($id);
        $plano->delete();
        return redirect('planos')->with('success', 'Registro removido com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request);
        $plano = Planos::findOrFail($id);
        $plano->update($request->except(['_token', '_method', 'id']));

        return redirect('planos')->with('success', 'Registro atualizado com sucesso!');
    }

    public function search(Request $request)
    {
        if (!empty($request->valor)) {
            $dados = Planos::where(
                $request->tipo,
                'like',
                '%' . $request->valor . '%'
            )->get();
        } else {
            $dados = Planos::all();
        }

        return view('planos.listplanos', compact('dados'));
    }

    private function validateForm(Request $request)
    {
        $request->validate([
            'nome_plano' => 'required|string|max:255',
            'preco_mensal' => 'required|numeric|min:0',
            'limite_telas' => 'required|integer|min:1',
            'resolucao_max' => 'required',
        ], [
            'nome_plano.required' => 'O campo nome do plano é obrigatório.',
            'preco_mensal.required' => 'O campo preço mensal é obrigatório.',
            'preco_mensal.numeric' => 'O campo preço mensal deve ser um número válido.',
            'preco_mensal.min' => 'O campo preço mensal deve ser um valor positivo.',
            'limite_telas.required' => 'O limite de telas é obrigatório.',
            'limite_telas.integer' => 'O campo limite de telas deve ser um número inteiro.',
            'limite_telas.min' => 'O campo limite de telas deve ser um valor positivo.',
            'resolucao_max.required' => 'A resolução máxima é obrigatória.',
        ]);
    }
}