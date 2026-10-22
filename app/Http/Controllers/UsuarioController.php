<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\AssinaturaEstado;

class UsuarioController extends Controller
{

    public function edit(Request $request): View
    {
        return view('usuario.edit', [
            'user' => $request->user(),
        ]);
    }
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $this->validateForm($request, $user->id);
        $user->fill($request->only(['name', 'email']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Upload de Imagem 2
        if ($request->hasFile('foto_perfil')) {
            // Apaga a foto antiga se existir
            if ($user->foto_perfil && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->foto_perfil)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto_perfil);
            }

            $imagem = $request->file('foto_perfil');
            $nome_imagem = 'user_' . $user->id . '_' . date('YmdHis') . '.' . $imagem->getClientOriginalExtension();
            $diretorio = "imagem/usuarios/";

            $imagem->storeAs($diretorio, $nome_imagem, 'public');
            $user->foto_perfil = $diretorio . $nome_imagem;
        }
        $user->save();
        return Redirect::route('usuario.edit')->with('status', 'usuario-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('/');
    }


    //Critério de Relacionamento 1:1
    //listagem de usuarios
    public function list(): View
    {
        $dados = User::with('assinaturaEstado')->get();// list.blafe busca os usuarios trazedo os dados do estado da assinatura realcionada tbm
        return view('usuario.list', compact('dados'));
    }

    public function search(Request $request): View
    {
        $tipo = $request->input('tipo', 'name');
        $valor = trim($request->input('valor'));

        $query = User::with('assinaturaEstado');

        if (!empty($valor)) {
            if ($tipo === 'status_assinatura') {
                // Busca filtrando diretamente pela tabela relacionada AssinaturaEstado
                $query->whereHas('assinaturaEstado', function ($q) use ($valor) {
                    $q->where('status', 'LIKE', "%{$valor}%");
                });
            } else {
                // Busca nas colunas da própria tabela 'users' (name, email, etc)
                $query->where($tipo, 'LIKE', "%{$valor}%");
            }
        }

        $dados = $query->get();
        return view('usuario.list', compact('dados'));
    }

    private function validateForm(Request $request, $userId)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $userId],
            'foto_perfil' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif'],
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Informe um endereço de e-mail válido.',
            'email.unique' => 'Este e-mail já está a ser utilizado por outro utilizador.',
            'foto_perfil.image' => 'O arquivo enviado deve ser uma imagem.',
            'foto_perfil.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif.',
        ]);
    }


    //gemini criou isso antes de eu fazer caca e esquecer de puxar da origem dps q vc mexeu, ent deixarei aqui
    public function editUser($id)
    {
        $dado = User::findOrFail($id);
        $assinaturas = AssinaturaEstado::all();

        // Altere de 'users.form' para 'usuario.form'
        return view('usuario.form', compact('dado', 'assinaturas'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user->update($request->only(['name', 'email', 'is_admin', 'assinaturaestado_id']));

        return redirect()->route('users.list')->with('success', 'Utilizador atualizado com sucesso!');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        // Evita que o administrador elimine a própria conta com que está logado
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Não pode eliminar a sua própria conta.');
        }

        $user->delete();

        return redirect()->route('users.list')->with('success', 'Utilizador eliminado com sucesso!');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->has('is_admin') ? 1 : 0,
            'assinaturaestado_id' => $request->assinaturaestado_id,
        ]);

        return redirect()->route('users.list')->with('success', 'Utilizador criado com sucesso!');
    }
}
