<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
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

        // Tratamento da imagem de perfil (caso seja enviada)
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

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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
        return view('users.list', compact('dados'));
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

        return view('users.list', compact('dados'));
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
}
