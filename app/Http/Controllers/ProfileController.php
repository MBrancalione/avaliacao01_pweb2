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
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

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
        $dados = User::with('assinaturaEstado')->get();// dados pq ele pega esse nome lá no list.blade
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
}
