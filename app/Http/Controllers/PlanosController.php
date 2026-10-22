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
        Planos::destroy($id);
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
            'nome_plano' => 'required',
            'preco_mensal' => 'required',
            'limite_telas' => 'required',
            'resolucao_max' => 'required',
        ], [
            'nome_plano.required' => 'O campo nome do plano é obrigatório.',
            'preco_mensal.required' => 'O campo preço mensal é obrigatório.',
            'limite_telas.required' => 'O limite de telas é obrigatório.',
            'resolucao_max.required' => 'A resolução máxima é obrigatória.',
        ]);
    }
}