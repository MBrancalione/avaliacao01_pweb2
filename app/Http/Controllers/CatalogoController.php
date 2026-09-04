<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogo; //necessário para chamar o model Catalogo

class CatalogoController extends Controller
{
    //listagem
    public function indexadmin()
    { 
        $dados = Catalogo::All();
        return view('catalogo.listcatalogo')->with(['dados'=> $dados]);
    }

    public function indexuser()
    { 
        $dados = Catalogo::All();
        return view('catalogo.listcatalogouser')->with(['dados'=> $dados]);
    }

    //criação
    function create(){
        return view('catalogo.formcatalogo');
    }

    //armazenamento
    function store(Request $request){
        Catalogo::create($request->all());
        return redirect('catalogoadmin')->with('success', 'Cadastro realizado com sucesso!');
    }
    

    //edição
    function edit($id){
        $dado = Catalogo::find($id);
        return view('catalogo.formcatalogo', compact('dado'));
    }

    //excluir
    function destroy($id){
        Catalogo::destroy($id);
        return redirect('catalogoadmin')->with("sucess", 'Registro removido com sucesso!');
    }

    //atualizar
    function update(Request $request, $id){
        //dd($request->all());
        $dado = Catalogo::find($id)->update($request->except(['_token', '_method', 'id']));
        return redirect('catalogoadmin')->with("sucess", 'Registro atualizado com sucesso!');
    }

    //busca na listagem
    public function searchadmin(Request $request){

    if(!empty($request->valor)){
        $dados = Catalogo::where(
            $request->tipo,
            'like',
            '%' . $request->valor . '%')->get();
    } else{
        $dados = Catalogo::All();
        }

        return view('catalogo.listcatalogo', compact('dados'));
    }

    public function searchuser(Request $request){

    if(!empty($request->valor)){
        $dados = Catalogo::where(
            $request->tipo,
            'like',
            '%' . $request->valor . '%')->get();
    } else{
        $dados = Catalogo::All();
        }

        return view('catalogo.listcatalogouser', compact('dados'));
    }


}
