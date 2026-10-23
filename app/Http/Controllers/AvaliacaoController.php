<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Avaliacao;
use App\Models\Filme;

class AvaliacaoController extends Controller
{
    public function index()
    {
        //$dados = Avaliacao::all();
        $dados = Avaliacao::with(['filme', 'user'])->get(); //Para que no relacionemtno ele mostre os nomes ao invés dos Ids!
        return view('avaliacao.listavaliacao', compact('dados'));
    }

    public function create(Request $request)
    {
        $filme_id = $request->filme_id; // pega o id que o botão do catalogo deu
       // $user_id = $request->session()->get('user_id'); // pega o id da sessão
        $filmes = Filme::orderBy('titulo')->get();
        return view('avaliacao.formavaliacao', compact('filme_id', 'user_id', 'filmes')); // retorna o form + id do botao
    }

    public function store(Request $request)
    {
        //dd($request->all());
        //verificação se o user_id está associado a uma avaliação
        $this->validateForm($request);
        if (Avaliacao::where('user_id', Auth::id())->where('filme_id', $request->filme_id)->exists()) {
            return redirect('avaliacao')->with('error', 'Você já avaliou este filme.');
        }
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['spoiler'] = $request->boolean('spoiler');
        Avaliacao::create($request->all());
        return redirect('avaliacao')->with('success', 'Cadastro realizado com sucesso!');
    }

    public function edit($id)
    {
        $dados = Avaliacao::findOrFail($id);
        $this->autorizar($dados);
        $filmes = Filme::orderBy('titulo')->get(); //serve para pegar todos os filmes e mostrar no select do form de avaliação
        return view('avaliacao.formavaliacao', compact('dados', 'filmes'));
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request);
        $dados = Avaliacao::findOrFail($id);
        $this->autorizar($dados);
        $data = $request->except(['_token', '_method', 'id', 'user_id']);
        $data['spoiler'] = $request->has('spoiler') ? 1 : 0;

        $dados->update($data);
        return redirect('avaliacao')->with('success', 'Registro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        //feito dessa forma para que o usuário não consiga deletar avaliações de outros usuários, apenas as suas próprias
        $dados = Avaliacao::findOrFail($id);
        $this->autorizar($dados);
        $dados->delete();
        return redirect('avaliacao')->with('success', 'Registro removido com sucesso!');
    }

    private function autorizar(Avaliacao $avaliacao)
    {
        abort_unless(Auth::user()->is_admin || (int) $avaliacao->user_id === Auth::id(), 403);
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
            'nota' => 'required|integer|between:1,5',
            'comentario' => 'required',
            'spoiler' => 'nullable|boolean',
        ], [
            'filme_id.required' => 'O ID do filme é obrigatório.',
            'filme_id.exists' => 'O filme selecionado não existe.',
            'nota.required' => 'O campo nota é obrigatório.',
            'nota.integer' => 'A nota deve ser um número inteiro.',
            'nota.between' => 'A nota deve estar entre 1 e 5.',
            'comentario.required' => 'O campo comentário é obrigatório.',
        ]);
    }
}