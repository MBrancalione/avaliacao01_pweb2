<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\PlanosController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\ChamadoController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    if (!auth()->user()->is_admin) {
        return redirect()->route('filmeuser');
    }
    return view('dashboard', [
        'totalFilmes' => \App\Models\Filme::count(),
        'totalPlanos' => \App\Models\Planos::count(),
        'totalUsuarios' => \App\Models\User::count(),
        'totalAvaliacoes' => \App\Models\Avaliacao::count(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/main', function () {
    return view('main');
})->middleware('auth')->name('main');


//Usuários
Route::middleware('auth')->group(function () {
    Route::get('/usuario', [UsuarioController::class, 'edit'])->name('usuario.edit');
    Route::patch('/usuario', [UsuarioController::class, 'update'])->name('usuario.update');
    Route::delete('/usuario', [UsuarioController::class, 'destroy'])->name('usuario.destroy');
});

// CORREÇÃO: gerenciar usuários é função de admin. Antes bastava estar logado: qualquer usuário
// podia abrir /users/edit/{id} e enviar is_admin=1 para virar administrador.
// Requer o middleware 'admin' (código no final desta seção).
Route::middleware(['auth', 'admin'])->group(function () {
    // Rotas de listagem e pesquisa de utilizadores (Relacionamento 1:1)
    Route::get('/users/list', [UsuarioController::class, 'list'])->name('users.list');
    Route::post('/users/search', [UsuarioController::class, 'search'])->name('users.search');

    // CORREÇÃO: faltavam as rotas de "Salvar" (storeUser existia no controller, mas sem rota)
    Route::get('/users/create', [UsuarioController::class, 'createUser'])->name('users.create');
    Route::post('/users/store', [UsuarioController::class, 'storeUser'])->name('users.store');

    // NOVAS ROTAS: Edição e Eliminação de Utilizadores (bater com os nomes 'user.edit' e 'user.destroy' da view)
    Route::get('/users/edit/{id}', [UsuarioController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [UsuarioController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [UsuarioController::class, 'destroyUser'])->name('users.destroy');

    Route::get('/users/pdf', [UsuarioController::class, 'relatorioUsuario'])->name('users.pdf');
    Route::get('generate-pdf', [UsuarioController::class, 'relatorioUsuario'])->name('users.pdf');
});

// Filmes
Route::middleware('auth')->group(function () {
    Route::get('/filme/graficogeneros', [FilmeController::class, 'graficoGeneros'])->name('filme.graficogeneros');
    Route::get('/filmeuser', [FilmeController::class, 'index'])->name('filmeuser');
    Route::post('/filme/searchuser', [FilmeController::class, 'search'])->name('filme.searchuser');
    // Rota para exibir o gráfico de avaliações de um filme específico
    // CORREÇÃO: o método grafico() não existia no controller. Também mudei a URL de '/filme/{id}' para
    // '/filme/grafico/{id}', porque '/filme/{id}' engolia qualquer GET em /filme/xxx. O NOME da rota continua igual.
    Route::get('/filme/grafico/{id}', [FilmeController::class, 'grafico'])->whereNumber('id')->name('filme.graficobarras');
});
// CORREÇÃO: CRUD de filmes só para admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/filmeadmin', [FilmeController::class, 'index'])->name('filmeadmin');
    Route::get('/filme/create', [FilmeController::class, 'create'])->name('filme.create');
    Route::post('/filme/store', [FilmeController::class, 'store'])->name('filme.store');
    Route::get('/filme/edit/{id}', [FilmeController::class, 'edit'])->name('filme.edit');
    Route::put('/filme/{id}', [FilmeController::class, 'update'])->name('filme.update');
    Route::delete('/filme/{id}', [FilmeController::class, 'destroy'])->name('filme.destroy');
    Route::post('/filme/searchadmin', [FilmeController::class, 'search'])->name('filme.searchadmin');
    // CORREÇÃO: 2º relatório em PDF (o 1º é o de chamados)
    Route::get('/filme/pdf', [FilmeController::class, 'generatePDF'])->name('filme.pdf');
});

//Planos
// CORREÇÃO: protegido por login + admin (se o usuário comum precisar ver os planos, deixe só index/search no grupo 'auth')
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/planos', [PlanosController::class, 'index'])->name('planos');
    Route::get('/planos/create', [PlanosController::class, 'create'])->name('planos.create');
    Route::post('/planos/store', [PlanosController::class, 'store'])->name('planos.store');
    Route::get('/planos/edit/{id}', [PlanosController::class, 'edit'])->name('planos.edit');
    Route::put('/planos/{id}', [PlanosController::class, 'update'])->name('planos.update');
    Route::delete('/planos/{id}', [PlanosController::class, 'destroy'])->name('planos.destroy');
    Route::post('/planos/search', [PlanosController::class, 'search'])->name('planos.search');
});

// CORREÇÃO: Avaliações e Chamados exigem login (o controller usa Auth::id())
Route::middleware('auth')->group(function () {
    //Avaliações
    Route::get('/avaliacao', [AvaliacaoController::class, 'index'])->name('avaliacao.index');
    Route::get('/avaliacao/create', [AvaliacaoController::class, 'create'])->name('avaliacao.create');
    Route::post('/avaliacao/store', [AvaliacaoController::class, 'store'])->name('avaliacao.store');
    Route::get('/avaliacao/edit/{id}', [AvaliacaoController::class, 'edit'])->name('avaliacao.edit');
    Route::put('/avaliacao/{id}', [AvaliacaoController::class, 'update'])->name('avaliacao.update');
    Route::delete('/avaliacao/{id}', [AvaliacaoController::class, 'destroy'])->name('avaliacao.destroy');
    Route::post('/avaliacao/search', [AvaliacaoController::class, 'search'])->name('avaliacao.search');

    //Chamados
    Route::get('/chamado', [ChamadoController::class, 'index'])->name('chamado.listchamado');
    Route::get('/chamado/create', [ChamadoController::class, 'create'])->name('chamado.create');
    Route::post('/chamado/store', [ChamadoController::class, 'store'])->name('chamado.store');
    Route::get('/chamado/edit/{id}', [ChamadoController::class, 'edit'])->name('chamado.edit');
    Route::put('/chamado/{id}', [ChamadoController::class, 'update'])->name('chamado.update');
    Route::delete('/chamado/{id}', [ChamadoController::class, 'destroy'])->name('chamado.destroy');
    Route::post('/chamado/search', [ChamadoController::class, 'search'])->name('chamado.search');
    //PDF  Chamados
    Route::get('generate-pdf', [ChamadoController::class, 'relatorioChamado'])->name('chamado.pdf');
});

require __DIR__ . '/auth.php';