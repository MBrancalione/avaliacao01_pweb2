<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Avaliacao;

class AvaliacaoController extends Controller
{
    public function index()
    {
        $dados = Avaliacao::all();
        return view('avaliacao.listavaliacao', compact('dados'));
    }

    public function create(Request $request)
    {
        //   $filme_id = $request->filme_id; // pega o id que o botão do filme deu
        $user_id = $request->session()->get('user_id'); // pega o id da sessão
        //$categorias = Filme::orderBy('nome')->get();
        //dd($user_id, $filme_id);
        return view('avaliacao.formavaliacao', compact('filme_id', 'user_id')); // retorna o form + id do botao
    } //Ryan?

    public function store(Request $request)
    {
        //dd($request->all());

        $this->validateForm($request);
        Avaliacao::create($request->all());
        //verificação se o user_id está associado a uma avaliação
        return redirect('avaliacao')->with('success', 'Cadastro realizado com sucesso!');
    }

    public function edit($id)
    {
        $dados = Avaliacao::findOrFail($id);
        return view('avaliacao.formavaliacao', compact('dados'));
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request);
        $dados = Avaliacao::findOrFail($id);
        $data['spoiler'] = $request->has('spoiler') ? 1 : 0;
        $dados->update($data);
        return redirect('avaliacao')->with('success', 'Registro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        Avaliacao::destroy($id);
        return redirect('avaliacao')->with('success', 'Registro removido com sucesso!');
    }

    public function search(Request $request)
    {
        if (!empty($request->valor)) {
            $dados = Avaliacao::with('filme')
                ->where($request->tipo, 'like', '%' . $request->valor . '%')
                ->get();
        } else {
            $dados = Avaliacao::with('filme')->get();
        }

        return view('avaliacao.listavaliacao', compact('dados'));
    }

    private function validateForm(Request $request)
    {
        $request->validate([
            'filme_id' => 'required|exists:filmes,id',
            'nota' => 'required|integer',
            'comentario' => 'required',
            'spoiler' => 'nullable|boolean',
        ], [
            'filme_id.required' => 'O ID do catálogo é obrigatório.',
            'filme_id.exists' => 'O catálogo selecionado não existe.',
            'nota.required' => 'O campo nota é obrigatório.',
            'nota.integer' => 'A nota deve ser um número inteiro.',
            'comentario.required' => 'O campo comentário é obrigatório.',
        ]);
    }
}