<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planos; //necessário para chamar o model Catalogo

class PlanosController extends Controller
{
    //listagem
    public function index()
    { 
        $dado = Planos::All();
        return view('planos.listplanos')->with(['dado'=> $dado]);
    }

    //criação
    function create(){
        return view('planos.formplanos');
    }

    //armazenamento
    function store(Request $request){
        Planos::create($request->all());
        return redirect('planos')->with('success', 'Cadastro realizado com sucesso!');
    }

    //edição
    function edit($id){
        $dado = Planos::find($id);
        return view('planos.formplanos', compact('dado'));
    }

    //excluir
    function destroy($id){
        Planos::destroy($id);
        return redirect('planos')->with("sucess", 'Registro removido com sucesso!');
    }

    //atualizar
    function update(Request $request, $id){
        //dd($request->all());
        $dado = Planos::find($id)->update($request->except(['_token', '_method', 'id']));
        return redirect('planos')->with("sucess", 'Registro atualizado com sucesso!');
    }

    //busca na listagem
    public function search(Request $request){

    if(!empty($request->valor)){
        $dado = Planos::where(
            $request->tipo,
            'like',
            '%' . $request->valor . '%')->get();
    } else{
        $dado = Planos::All();
        }
    
        return view('planos.listplanos', compact('dado'));
    }
}
