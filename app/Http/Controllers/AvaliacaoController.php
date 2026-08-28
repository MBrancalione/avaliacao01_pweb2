<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avaliacao; //necessário para chamar o model Catalogo

class AvaliacaoController extends Controller
{
    //listagem
    public function index()
    { 
        $dados = Avaliacao::All();
        return view('avaliacao.listavaliacao')->with(['dados'=> $dados]);
    }

    //criação
    function create(){
        return view('avaliacao.formavaliacao');
    }

    //armazenamento
    function store(Request $request){
        Avaliacao::create($request->all());
        return redirect('avaliacao')->with('success', 'Cadastro realizado com sucesso!');
    }

    //edição
    function edit($id){
        $dado = Avaliacao::find($id);
        return view('avaliacao.formavaliacao', compact('dado'));
    }

    //excluir
    function destroy($id){
        Avaliacao::destroy($id);
        return redirect('avaliacao')->with("sucess", 'Registro removido com sucesso!');
    }

    //atualizar
    function update(Request $request, $id){
        //dd($request->all());
        $dado = Avaliacao::find($id)->update($request->except(['_token', '_method', 'id']));
        return redirect('avaliacao')->with("sucess", 'Registro atualizado com sucesso!');
    }

    //busca na listagem
    public function search(Request $request){

    if(!empty($request->valor)){
        $dados = Avaliacao::where(
            $request->tipo,
            'like',
            '%' . $request->valor . '%')->get();
    } else{
        $dados = Avaliacao::All();
        }

        return view('avaliacao.listavaliacao', compact('dados'));
    }
}
