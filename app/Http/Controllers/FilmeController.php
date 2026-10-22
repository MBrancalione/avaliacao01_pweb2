<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; //necessário para manipular arquivos
use App\Models\Filme; //necessário para chamar o model Filme
use App\Models\GeneroFilme;

class FilmeController extends Controller
{

//reduzir para uma função o index tbm
    public function index(Request $request)
    {
        $dados = Filme::all();
        if ($request->is('*admin*')) {
            return view('filme.listfilme', compact('dados'));
        }
        return view('filme.listfilmeuser', compact('dados'));
    }

    function create()
    {
        $generos = GeneroFilme::pluck('genero_filme');//pluck pega só uma coluna

        return view('filme.formfilme', compact('generos'));
    }

    function store(Request $request)
    {
        //dd($request->all());
        $this->validateForm($request);

        $data = $request->all(); // Obtém todos os dados do formulário
        $imagem = $request->file('poster'); // Obtém o arquivo de imagem enviado no formulário

        if ($imagem) { // Verifica se um arquivo de imagem foi enviado
            $nome_imagem = date('YmdHis') . '.' . $imagem->getClientOriginalExtension(); // Gera um nome único para a imagem usando a data e hora atual
            $diretorio = "imagem/filme/"; // Define o diretório onde a imagem será armazenada. O diretório fica dentro da pasta 'public' do Laravel, então o caminho completo será 'public/imagem/filme/'
            $imagem->storeAs($diretorio, $nome_imagem, 'public'); // Armazena a imagem no diretório especificado dentro do disco 'public'
            $data['poster'] = $diretorio . $nome_imagem; // Atualiza o campo 'poster' com o caminho completo da imagem armazenada
        }

        Filme::create($data); 
        return redirect('filmeadmin')->with('success', 'Cadastro realizado com sucesso!');
    }


    function edit($id)
    {
        $dado = Filme::findOrFail($id); //ao invés de retornar apenas o erro, caso fosse só find, retorna qual o problema
        $generos = GeneroFilme::all(); // Procura todos os gen existentes p mandar junto do filme
        return view('filme.formfilme', compact('dado', 'generos'));
    }

    function destroy($id)
    {   
        $filme = Filme::findOrFail($id); // Encontra o registro do catálogo pelo ID ou lança uma exceção se não encontrado
        if ($filme->poster && Storage::disk('public')->exists($filme->poster)) {
            Storage::disk('public')->delete($filme->poster);
        }
        $filme->delete(); // Remove o registro do catálogo do banco de dados
        return redirect('filmeadmin')->with("success", 'Registro removido com sucesso!');
    }

    function update(Request $request, $id)
    {
        $this->validateForm($request);

            $filme = Filme::findOrFail($id);
        $data = $request->all(); // Obtém todos os dados do formulário
        $imagem = $request->file('poster'); // Obtém o arquivo de imagem enviado no formulário

        if ($imagem) { // Verifica se um arquivo de imagem foi enviado

        if ($filme->poster && Storage::disk('public')->exists($filme->poster)) {
                Storage::disk('public')->delete($filme->poster);
            }

            $nome_imagem = date('YmdHis') . '.' . $imagem->getClientOriginalExtension(); // Gera um nome único para a imagem usando a data e hora atual
            $diretorio = "imagem/filme/"; // Define o diretório onde a imagem será armazenada. O diretório fica dentro da pasta 'public' do Laravel, então o caminho completo será 'public/imagem/filme/'
            $imagem->storeAs($diretorio, $nome_imagem, 'public'); // Armazena a imagem no diretório especificado dentro do disco 'public'
            $data['poster'] = $diretorio . $nome_imagem; // Atualiza o campo 'poster' com o caminho completo da imagem armazenada
        }
        //dd($request->all());

$filme->update($data);
        return redirect('filmeadmin')->with("success", 'Registro atualizado com sucesso!');
    }



    //ajustar isso aqui em todos os cruds
    function validateForm(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'sinopse' => 'required|string',
            'genero_filme' => 'required',
            'classificacao' => 'required',
            'ano' => 'required',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif', 
        ], [
            'titulo.required' => 'O campo título é obrigatório.',
            'sinopse.required' => 'O campo sinopse é obrigatório.',
            'genero_filme.required' => 'O campo gênero é obrigatório.',
            'classificacao.required' => 'O campo classificação é obrigatório.',
            'ano.required' => 'O campo ano é obrigatório.',
            'poster.image' => 'O arquivo enviado deve ser uma imagem.',
            'poster.mimes' => 'O arquivo enviado deve ser do tipo: jpeg, png, jpg, gif.',
        ]);
    }

 public function search(Request $request)
    {
        if (!empty($request->valor)) {
            $dados = Filme::where(
                $request->tipo,
                'like',
                '%' . $request->valor . '%'
            )->get();
        } else {
            $dados = Filme::all();
        }

        // Retorna para a view correta dependendo de onde a requisição partiu
        if ($request->is('*admin*')) {
            return view('filme.listfilme', compact('dados'));
        }

        return view('filme.listfilmeuser', compact('dados'));
    }
}
