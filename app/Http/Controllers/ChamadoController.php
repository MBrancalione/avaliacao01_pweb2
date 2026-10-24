<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chamado;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ChamadoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
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
        return view('chamado.formchamado');
    }

    public function store(Request $request)
    {
        $this->validateForm($request);
        $data = $request->all();
        $data['user_id'] = Auth::id();

        Chamado::create($data);
        return redirect('chamado')->with('success', 'Cadastro realizado com sucesso!');
    }
    private function autorizar(Chamado $chamado)
    {
        abort_unless(Auth::user()->is_admin || (int) $chamado->user_id === Auth::id(), 403);
    }

    public function edit($id)
    {
        $dado = Chamado::findOrFail($id);
        $this->autorizar($dado);

        return view('chamado.formchamado', compact('dado'));
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request);

        $dado = Chamado::findOrFail($id);
        $this->autorizar($dado);
        $dado->update($request->except(['_token', '_method', 'id', 'user_id',]));

        return redirect('chamado')->with("success", 'Registro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $dado = Chamado::findOrFail($id);
        $this->autorizar($dado);

        $dado->delete();

        return redirect('chamado')->with("success", 'Registro removido com sucesso!');
    }
    private function consultaChamados()
    {
        $query = Chamado::with('user');
        if (!(Auth::user() && Auth::user()->is_admin)) {
            $query->where('user_id', Auth::id());
        }
        return $query;
    }
    public function search(Request $request)
    {
        $query = $this->consultaChamados();

        if (!empty($request->valor)) {
            $query->where($request->tipo, 'like', '%' . $request->valor . '%');
        }
        $dados = $query->get();
        return view('chamado.listchamado', compact('dados'));
    }

    public function relatorioChamado()
    {
        $chamados = $this->consultaChamados()->get();
        $data = [
            'title' => 'Relatório de Chamados',
            'date' => date('d/m/Y'),
            'chamados' => $chamados
        ];
        $pdf = PDF::loadView('chamado.reportchamado', $data);
        return $pdf->download('chamados.pdf');
    }
    private function validateForm(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'descricao' => 'required',
            'status' => 'required',
            'data_criacao' => 'required|date',
            'data_encerramento' => 'nullable|date',
        ], [
            'titulo.required' => 'O campo título é obrigatório.',
            'status.required' => 'O campo status é obrigatório.',
            'data_criacao.date' => 'A data de criação é obrigatória.',
            'data_encerramento.date' => 'A data de encerramento deve ser uma data válida.',
        ]);
    }
}