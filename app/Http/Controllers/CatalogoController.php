<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; //necessário para manipular arquivos
use App\Models\Catalogo; //necessário para chamar o model Catalogo

class CatalogoController extends Controller
{

//reduzir para uma função o index tbm
    public function index(Request $request)
    {
        $dados = Catalogo::all();
        if ($request->is('*admin*')) {
            return view('catalogo.listcatalogo', compact('dados'));
        }
        return view('catalogo.listcatalogouser', compact('dados'));
    }

    function create()
    {
        return view('catalogo.formcatalogo');
    }

    function store(Request $request)
    {
        $this->validateForm($request);

        $data = $request->all(); // Obtém todos os dados do formulário
        $imagem = $request->file('poster'); // Obtém o arquivo de imagem enviado no formulário

        if ($imagem) { // Verifica se um arquivo de imagem foi enviado
            $nome_imagem = date('YmdHis') . '.' . $imagem->getClientOriginalExtension(); // Gera um nome único para a imagem usando a data e hora atual
            $diretorio = "imagem/catalogo/"; // Define o diretório onde a imagem será armazenada. O diretório fica dentro da pasta 'public' do Laravel, então o caminho completo será 'public/imagem/catalogo/'
            $imagem->storeAs($diretorio, $nome_imagem, 'public'); // Armazena a imagem no diretório especificado dentro do disco 'public'
            $data['poster'] = $diretorio . $nome_imagem; // Atualiza o campo 'poster' com o caminho completo da imagem armazenada
        }

        Catalogo::create($data); 
        return redirect('catalogoadmin')->with('success', 'Cadastro realizado com sucesso!');
    }


    function edit($id)
    {
        $dado = Catalogo::findOrFail($id); //ao invés de retornar apenas o erro, caso fosse só find, retorna qual o problema
        return view('catalogo.formcatalogo', compact('dado'));
    }

    function destroy($id)
    {   
        $catalogo = Catalogo::findOrFail($id); // Encontra o registro do catálogo pelo ID ou lança uma exceção se não encontrado
        if ($catalogo->poster && Storage::disk('public')->exists($catalogo->poster)) {
            Storage::disk('public')->delete($catalogo->poster);
        }
        $catalogo->delete(); // Remove o registro do catálogo do banco de dados
        return redirect('catalogoadmin')->with("success", 'Registro removido com sucesso!');
    }

    function update(Request $request, $id)
    {
        $this->validateForm($request);

            $catalogo = Catalogo::findOrFail($id);
        $data = $request->all(); // Obtém todos os dados do formulário
        $imagem = $request->file('poster'); // Obtém o arquivo de imagem enviado no formulário

        if ($imagem) { // Verifica se um arquivo de imagem foi enviado

        if ($catalogo->poster && Storage::disk('public')->exists($catalogo->poster)) {
                Storage::disk('public')->delete($catalogo->poster);
            }

            $nome_imagem = date('YmdHis') . '.' . $imagem->getClientOriginalExtension(); // Gera um nome único para a imagem usando a data e hora atual
            $diretorio = "imagem/catalogo/"; // Define o diretório onde a imagem será armazenada. O diretório fica dentro da pasta 'public' do Laravel, então o caminho completo será 'public/imagem/catalogo/'
            $imagem->storeAs($diretorio, $nome_imagem, 'public'); // Armazena a imagem no diretório especificado dentro do disco 'public'
            $data['poster'] = $diretorio . $nome_imagem; // Atualiza o campo 'poster' com o caminho completo da imagem armazenada
        }
        //dd($request->all());

$catalogo->update($data);
        return redirect('catalogoadmin')->with("success", 'Registro atualizado com sucesso!');
    }



    //ajustar isso aqui em todos os cruds
    function validateForm(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'sinopse' => 'required|string',
            'genero' => 'required',
            'classificacao' => 'required',
            'ano' => 'required',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif', 
        ], [
            'titulo.required' => 'O campo título é obrigatório.',
            'sinopse.required' => 'O campo sinopse é obrigatório.',
            'genero.required' => 'O campo gênero é obrigatório.',
            'classificacao.required' => 'O campo classificação é obrigatório.',
            'ano.required' => 'O campo ano é obrigatório.',
            'poster.image' => 'O arquivo enviado deve ser uma imagem.',
            'poster.mimes' => 'O arquivo enviado deve ser do tipo: jpeg, png, jpg, gif.',
        ]);
    }

 public function search(Request $request)
    {
        if (!empty($request->valor)) {
            $dados = Catalogo::where(
                $request->tipo,
                'like',
                '%' . $request->valor . '%'
            )->get();
        } else {
            $dados = Catalogo::all();
        }

        // Retorna para a view correta dependendo de onde a requisição partiu
        if ($request->is('*admin*')) {
            return view('catalogo.listcatalogo', compact('dados'));
        }

        return view('catalogo.listcatalogouser', compact('dados'));
    }
}
