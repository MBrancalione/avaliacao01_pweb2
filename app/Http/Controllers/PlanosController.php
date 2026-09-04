<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planos;

class PlanosController extends Controller
{
    public function index()
    {
        $dados = Planos::All();
        return view('planos.listplanos')->with(['dados' => $dados]);
    }

    function create()
    {
        return view('planos.formplanos');
    }

    function store(Request $request)
    {

        $request->validate([
            'nome_planos' => 'required|string|max:255',
            'preco_mensal' => 'required|numeric|min:0',
            'limite_telas' => 'required|integer|min:1',
            'resolucao_max' => 'required|string|max:50',
        ]);

        Planos::create($request->all());
        return redirect('planos')->with('success', 'Cadastro realizado com sucesso!');
    }

    function edit($id)
    {
        $dados = Planos::findorFail($id);
        return view('planos.formplanos', compact('dados'));
    }


    function destroy($id)
    {
        Planos::destroy($id);
        return redirect('planos')->with("success", 'Registro removido com sucesso!');
    }

    function update(Request $request, $id)
    {

        $request->validate([
            'nome_planos' => 'required|string|max:255',
            'preco_mensal' => 'required|numeric|min:0',
            'limite_telas' => 'required|integer|min:1',
            'resolucao_max' => 'required|string|max:50',
        ]);

        $dados = Planos::find($id)->update($request->except(['_token', '_method', 'id']));
        return redirect('planos')->with("success", 'Registro atualizado com sucesso!');
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
            $dados = Planos::All();
        }

        return view('planos.listplanos', compact('dados'));
    }
}
