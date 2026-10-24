<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; //necessário para manipular arquivos
use App\Models\Filme; //necessário para chamar o model Filme
use App\Models\GeneroFilme;
use App\Models\Avaliacao;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Charts\FilmesPorGeneroChart;

class FilmeController extends Controller
{

    //reduzir para uma função o index tbm
    public function index(Request $request)
    {
        $dados = Filme::with('GeneroFilme')->get();
        if ($request->is('*admin*')) {
            return view('filme.listfilme', compact('dados'));
        }
        return view('filme.listfilmeuser', compact('dados'));
    }

    function create()
    {
        $generos = GeneroFilme::all();
        return view('filme.formfilme', compact('generos'));
    }

    function store(Request $request)
    {
        //dd($request->all());
        $this->validateForm($request);

        $data = $request->except('poster');
        $imagem = $request->file('poster');

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
        $data = $request->except('poster');
        $imagem = $request->file('poster');

        if ($imagem) {

            if ($filme->poster && Storage::disk('public')->exists($filme->poster)) {
                Storage::disk('public')->delete($filme->poster);
            }

            $nome_imagem = date('YmdHis') . '.' . $imagem->getClientOriginalExtension(); // Gera um nome único para a imagem usando a data e hora atual
            $diretorio = "imagem/filme/"; // Define o diretório onde a imagem será armazenada. O diretório fica dentro da pasta 'public' do Laravel, então o caminho completo será 'public/imagem/filme/'
            $imagem->storeAs($diretorio, $nome_imagem, 'public');
            $data['poster'] = $diretorio . $nome_imagem;
        }
        //dd($request->all());

        $filme->update($data);
        return redirect('filmeadmin')->with("success", 'Registro atualizado com sucesso!');
    }

    //ajustar isso aqui em todos os cruds
    function validateForm(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'sinopse' => 'required|string|max:255',
            'genero_filme' => 'required|exists:genero_filmes,id',
            'classificacao' => 'required|in:L,10,12,14,16,18',
            'ano' => 'required|digits:4|integer|min:1888|max:' . (date('Y') + 1),
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'titulo.required' => 'O campo título é obrigatório.',
            'sinopse.required' => 'O campo sinopse é obrigatório.',
            'sinopse.max' => 'A sinopse pode ter no máximo 255 caracteres.',
            'genero_filme.required' => 'O campo gênero é obrigatório.',
            'genero_filme.exists' => 'O gênero selecionado não existe.',
            'classificacao.required' => 'O campo classificação é obrigatório.',
            'classificacao.in' => 'Classificação inválida.',
            'ano.required' => 'O campo ano é obrigatório.',
            'ano.digits' => 'O ano deve ter 4 dígitos.',
            'poster.image' => 'O arquivo enviado deve ser uma imagem.',
            'poster.mimes' => 'O arquivo enviado deve ser do tipo: jpeg, png, jpg, gif.',
            'poster.max' => 'A imagem pode ter no máximo 2MB.',
        ]);
    }

    public function search(Request $request)
    {
        if (!empty($request->valor)) {
            if ($request->tipo === 'genero_filme') {
                $dados = Filme::with('GeneroFilme')->whereHas('GeneroFilme', function ($q) use ($request) {
                    $q->where('genero_filme', 'like', '%' . $request->valor . '%');
                })->get();
            } else {
                $dados = Filme::with('GeneroFilme')->where($request->tipo, 'like', '%' . $request->valor . '%')->get();
            }
        } else {
            $dados = Filme::with('GeneroFilme')->get();
        }

        if ($request->is('*admin*')) {
            return view('filme.listfilme', compact('dados'));
        }

        return view('filme.listfilmeuser', compact('dados'));
    }

    public function grafico($id)
    {
        $filme = Filme::with('GeneroFilme')->findOrFail($id);
        $contagem = Avaliacao::where('filme_id', $id)
            ->selectRaw('nota, COUNT(*) as total')
            ->groupBy('nota')
            ->pluck('total', 'nota');


        $notas = [5, 4, 3, 2, 1];
        $valores = collect($notas)->map(fn($n) => $contagem->get($n, 0))->all();

        $total = array_sum($valores);
        $media = Avaliacao::where('filme_id', $id)->avg('nota');

        $chart = (new LarapexChart)->barChart()
            ->setTitle('Avaliações de ' . $filme->titulo)
            ->setSubtitle('Quantidade de avaliações por nota')
            ->addData($valores, 'Avaliações')
            ->setXAxis(array_map('strval', $notas))
            ->setColors(['#4c32a8']);

        return view('filme.graficobarras', compact('filme', 'chart', 'total', 'media'));
    }

    public function graficoGeneros(FilmesPorGeneroChart $chart)
    {
        return view('filme.graficosetores', [
            'chart' => $chart->build()
        ]);
    }
}
