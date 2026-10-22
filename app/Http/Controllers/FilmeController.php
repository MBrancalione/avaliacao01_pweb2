<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Filme;
use App\Models\GeneroFilme;
use App\Charts\AvaliacaoChart;

class FilmeController extends Controller
{

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
        $generos = GeneroFilme::orderBy('genero_filme')->get(); // Obtém todos os gêneros ordenados pelo nome
        return view('filme.formfilme', compact('generos')); // Passa os gêneros para a view
    }

    function store(Request $request)
    {
        $this->validateForm($request);

        $data = $request->all(); // Obtém todos os dados do formulário
        $imagem = $request->file('poster'); // Obtém o arquivo de imagem enviado no formulário

        //Upload de Imagem 1
        if ($imagem) {
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
        $generos = GeneroFilme::orderBy('genero_filme')->get();
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

    function validateForm(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'sinopse' => 'required|string',
            'genero_filme_id' => 'required', // Corrigido nome da coluna e da tabela
            'classificacao' => 'required',
            'ano' => 'required',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ], [
            'titulo.required' => 'O campo título é obrigatório.',
            'sinopse.required' => 'O campo sinopse é obrigatório.',
            'genero_filme_id.required' => 'O campo gênero é obrigatório.', 
            'genero_filme_id.exists' => 'O gênero selecionado é inválido.',
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

    //Gráfico de Barras das Avaliações dos filmes
    public function grafico($id, AvaliacaoChart $chart)
    {
        $filme = Filme::with('avaliacoes')->findOrFail($id);

        return view('filme.graficobarras', [
            'filme' => $filme,
            'chart' => $chart->build($id) // Passa o ID do filme para o gráfico
        ]);
    }
}
