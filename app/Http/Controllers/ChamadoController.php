<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chamado;
use Illuminate\Support\Facades\Auth;
use PDF;

class ChamadoController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Admin vê todos os chamados. Usuário comum vê apenas os seus próprios.
        if ($user && $user->is_admin) {
            $dados = Chamado::with('user')->get();
        } else {
            $dados = Chamado::where('user_id', Auth::id())->with('user')->get();
        }

        return view('chamado.listchamado', compact('dados'));
    }
    public function create()
    {
        if (Auth::user() && Auth::user()->is_admin) {
            return redirect('chamado')->with('error', 'Administradores apenas visualizam chamados.');
        }

        // Alterado de 'chamado.form' para 'chamado.formchamado'
        return view('chamado.formchamado');
    }

    public function store(Request $request)
    {
        $data['data_criacao'] = now();      // Pega data e hora atuais do sistema
        $this->validateForm($request);

        $data = $request->all();


        // Atribui automaticamente o ID do utilizador logado caso não venha no formulário
        if (!isset($data['user_id'])) {
            $data['user_id'] = Auth::id() ?? 1; // Fallback de segurança se não houver sessão ativa
        }

        Chamado::create($data);
        return redirect('chamado')->with('success', 'Cadastro realizado com sucesso!');
    }

    public function edit($id)
    {
        $dado = Chamado::findOrFail($id);
        return view('chamado.formchamado', compact('dado'));
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request);

        $dado = Chamado::findOrFail($id);
        $dado->update($request->except(['_token', '_method', 'id']));

        return redirect('chamado')->with("success", 'Registro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $dado = Chamado::findOrFail($id);
        $dado->delete();

        return redirect('chamado')->with("success", 'Registro removido com sucesso!');
    }

    // Método centralizado de validação (padrão aplicado em todos os CRUDs)
    private function validateForm(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'descricao' => 'nullable',
            'status' => 'required',
            'data_criacao' => 'nullable|date',
            'data_encerramento' => 'nullable|date',
        ], [
            'titulo.required' => 'O campo título é obrigatório.',
            'status.required' => 'O campo status é obrigatório.',
            'data_criacao.date' => 'A data de criação deve ser uma data válida.',
            'data_encerramento.date' => 'A data de encerramento deve ser uma data válida.',
        ]);
    }

    public function search(Request $request)
    {
        $query = Chamado::with('user');

        if (!empty($request->valor)) {
            $query->where($request->tipo, 'like', '%' . $request->valor . '%');
        }

        $dados = $query->get();

        return view('chamado.list', compact('dados'));
    }

        public function generatePDF()

    {

        $chamados = Chamado::get();
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y'),
            'chamados' => $chamados
        ]; 
        $pdf = PDF::loadView('chamado.reportchamado', $data);
        return $pdf->download('chamados.pdf');

    }
}