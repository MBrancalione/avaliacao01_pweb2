<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Models\User;
use App\Models\AssinaturaEstado;
use Barryvdh\DomPDF\Facade\Pdf;

class UsuarioController extends Controller
{
    public function createUser()
    {
        // só assinaturas que ainda não pertencem a nenhum usuário (users.assinaturaestado_id é unique = 1:1)
        $assinaturas = AssinaturaEstado::whereDoesntHave('user')->get();
        return view('usuario.form', compact('assinaturas'));
    }

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

        // nome, e-mail e endereço
        $user->fill($request->only([
            'name',
            'email',
            'cep',
            'logradouro',
            'numero',
            'complemento',
            'bairro',
            'cidade',
            'estado',
        ]));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Upload de Imagem
        if ($request->hasFile('foto_perfil')) {
            // Apaga a foto antiga se existir
            if ($user->foto_perfil && Storage::disk('public')->exists($user->foto_perfil)) {
                Storage::disk('public')->delete($user->foto_perfil);
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

        if ($user->foto_perfil && Storage::disk('public')->exists($user->foto_perfil)) {
            Storage::disk('public')->delete($user->foto_perfil);
        }

        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('/');
    }


    //listagem de usuarios
    public function list(): View
    {
        // traz a assinatura e o plano dela, porque a listagem mostra o nome do plano
        $dados = User::with('assinaturaEstado.plano')->get();
        return view('usuario.list', compact('dados'));
    }

    public function search(Request $request): View
    {
        $tipo = $request->input('tipo', 'name');
        $valor = trim((string) $request->input('valor'));

        $query = User::with('assinaturaEstado.plano');

        if (!empty($valor)) {
            if ($tipo === 'status_assinatura') {
                // Busca filtrando diretamente pela tabela relacionada AssinaturaEstado
                $query->whereHas('assinaturaEstado', function ($q) use ($valor) {
                    $q->where('status', 'LIKE', "%{$valor}%");
                });
            } elseif (in_array($tipo, ['name', 'email'])) {
                // só colunas permitidas (impede buscar em password, remember_token, etc)
                $query->where($tipo, 'LIKE', "%{$valor}%");
            }
        }

        $dados = $query->get();
        return view('usuario.list', compact('dados'));
    }

    // única validação do controller: usada por update (perfil), storeUser e updateUser
    // $userId vazio = cadastro novo; com $userId = edição (ignora o próprio registro nos unique)
    private function validateForm(Request $request, $userId = null)
    {
        $regras = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'assinaturaestado_id' => ['nullable', 'exists:assinatura_estados,id', Rule::unique('users', 'assinaturaestado_id')->ignore($userId)],
            'foto_perfil' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'cep' => ['nullable', 'regex:/^\d{5}-?\d{3}$/'],
            'logradouro' => ['nullable', 'string', 'max:255'],
            'numero' => ['nullable', 'string', 'max:20'],
            'complemento' => ['nullable', 'string', 'max:255'],
            'bairro' => ['nullable', 'string', 'max:255'],
            'cidade' => ['nullable', 'string', 'max:255'],
            'estado' => ['nullable', 'string', 'size:2'],
        ];

        // a senha só é exigida ao criar um usuário (storeUser chama sem $userId)
        if (!$userId) {
            $regras['password'] = ['required', 'string', 'min:8'];
        }

        $request->validate($regras, [
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Informe um endereço de e-mail válido.',
            'email.unique' => 'Este e-mail já está sendo utilizado por outro usuário.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'assinaturaestado_id.exists' => 'A assinatura selecionada não existe.',
            'assinaturaestado_id.unique' => 'Esta assinatura já pertence a outro usuário.',
            'foto_perfil.image' => 'O arquivo enviado deve ser uma imagem.',
            'foto_perfil.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif.',
            'foto_perfil.max' => 'A imagem pode ter no máximo 2MB.',
            'cep.regex' => 'Informe o CEP no formato 00000-000.',
            'estado.size' => 'O estado deve ter 2 letras (UF).',
        ]);
    }


    public function editUser($id)
    {
        $dado = User::findOrFail($id);

        // assinaturas livres + a que o próprio usuário já tem (para continuar aparecendo selecionada)
        $assinaturas = AssinaturaEstado::whereDoesntHave('user')
            ->orWhere('id', $dado->assinaturaestado_id)
            ->get();

        return view('usuario.form', compact('dado', 'assinaturas'));
    }

    public function updateUser(Request $request, $id)
{
    $user = User::findOrFail($id);

    $this->validateForm($request, $id);

    $data = $request->only([
        'name',
        'email',
        'assinaturaestado_id',
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
    ]);

    // checkbox desmarcado não é enviado no formulário, por isso boolean()
    $data['is_admin'] = $request->boolean('is_admin');

    // o administrador não pode tirar o próprio acesso de administrador
    if ($user->id === Auth::id()) {
        $data['is_admin'] = true;
    }

    // Upload de Imagem
    if ($request->hasFile('foto_perfil')) {
        // Apaga a foto antiga se existir
        if ($user->foto_perfil && Storage::disk('public')->exists($user->foto_perfil)) {
            Storage::disk('public')->delete($user->foto_perfil);
        }

        $imagem = $request->file('foto_perfil');
        $nome_imagem = 'user_' . $user->id . '_' . date('YmdHis') . '.' . $imagem->getClientOriginalExtension();
        $diretorio = "imagem/usuarios/";

        $imagem->storeAs($diretorio, $nome_imagem, 'public');
        
        // Atribui diretamente ao array $data para atualizar via update()
        $data['foto_perfil'] = $diretorio . $nome_imagem;
    }

    $user->update($data);

    return redirect()->route('users.list')->with('success', 'Usuário atualizado com sucesso!');
}

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        // Evita que o administrador exclua a própria conta com que está logado
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Você não pode excluir a sua própria conta.');
        }

        if ($user->foto_perfil && Storage::disk('public')->exists($user->foto_perfil)) {
            Storage::disk('public')->delete($user->foto_perfil);
        }

        $user->delete();

        return redirect()->route('users.list')->with('success', 'Usuário excluído com sucesso!');
    }

    public function storeUser(Request $request)
    {
        $this->validateForm($request);

        // Upload de Imagem (o usuário ainda não tem id, por isso o nome usa só a data e hora)
        $foto_perfil = null;
        if ($request->hasFile('foto_perfil')) {
            $imagem = $request->file('foto_perfil');
            $nome_imagem = 'user_' . date('YmdHis') . '.' . $imagem->getClientOriginalExtension();
            $diretorio = "imagem/usuarios/";

            $imagem->storeAs($diretorio, $nome_imagem, 'public');
            $foto_perfil = $diretorio . $nome_imagem;
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->has('is_admin') ? 1 : 0,
            'assinaturaestado_id' => $request->assinaturaestado_id,
            'foto_perfil' => $foto_perfil,
            'cep' => $request->cep,
            'logradouro' => $request->logradouro,
            'numero' => $request->numero,
            'complemento' => $request->complemento,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
        ]);

        return redirect()->route('users.list')->with('success', 'Usuário criado com sucesso!');
    }

    public function relatorioUsuario()
    {
        $usuarios = $this->consultaUsuarios()->get();

        $data = [
            'title' => 'Relatório de Usuários',
            'date' => date('d/m/Y H:i'),
            'usuarios' => $usuarios, // a view usa a variável $usuarios
        ];

        // paisagem: a tabela do relatório tem 8 colunas
        $pdf = Pdf::loadView('usuario.reportusers', $data)->setPaper('a4', 'landscape');

        return $pdf->download('relatorio-usuarios.pdf');
    }

    private function consultaUsuarios()
    {
        // carrega o relacionamento 1:1 com a assinatura e o plano dela
        $query = User::with('assinaturaEstado.plano')->orderBy('name');

        // admin vê todos; usuário comum vê só o próprio registro
        if (!(Auth::user() && Auth::user()->is_admin)) {
            $query->where('id', Auth::id());
        }

        return $query;
    }

}