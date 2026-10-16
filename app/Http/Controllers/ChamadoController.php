<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chamado; //necessário para chamar o model Chamado

class ChamadoController extends Controller
{
    public function index()
    {
        $dados = Chamado::All();
        return view('chamado.list')->with(['dados' => $dados]);
    }

    public function indexuser()
    {
        $dados = Chamado::All();
        return view('chamado.list')->with(['dados' => $dados]);
    }

    function create()
    {
        return view('chamado.form');
    }

    function store(Request $request)
    {

        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'status' => 'required|string|max:50',
            'data_criacao' => 'nullable|date',
            'data_encerramento' => 'nullable|date',
        ]);

        Chamado::create($validatedData);
        return redirect('chamado.list')->with('success', 'Cadastro realizado com sucesso!');
    }


    function edit($id)
    {
        $dado = Chamado::findOrFail($id); //ao invés de retornar apenas o erro, caso fosse só find, retorna qual o problema
        return view('chamado.form', compact('dado'));
    }

    function destroy($id)
    {
        Chamado::destroy($id);
        return redirect('chamado.list')->with("success", 'Registro removido com sucesso!');
    }

    function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'status' => 'required|string|max:50',
            'data_criacao' => 'nullable|date',
            'data_encerramento' => 'nullable|date',
        ]);
        //dd($request->all());
        $dado = Chamado::find($id)->update($request->except(['_token', '_method', 'id']));
        return redirect('chamado.list')->with("success", 'Registro atualizado com sucesso!');
    }

    public function search(Request $request)
    {

        if (!empty($request->valor)) {
            $dados = Chamado::where(
                $request->tipo,
                'like',
                '%' . $request->valor . '%'
            )->get();
        } else {
            $dados = Chamado::All();
        }

        return view('chamado.list', compact('dados'));
    }
}
