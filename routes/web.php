<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\PlanosController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\ChamadoController;
use App\Models\Avaliacao;
use App\Models\Filme;
use App\Models\Planos;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (!auth()->user()->is_admin) {
        return redirect()->route('filmeuser');
    }

    return view('dashboard', [
        'totalFilmes'     => Filme::count(),
        'totalPlanos'     => Planos::count(),
        'totalUsuarios'   => User::count(),
        'totalAvaliacoes' => Avaliacao::count(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/main', function () {
    return view('main');
})->middleware('auth')->name('main');


// Perfil Usuário
Route::middleware('auth')->group(function () {
    Route::get('/usuario', [UsuarioController::class, 'edit'])->name('usuario.edit');
    Route::patch('/usuario', [UsuarioController::class, 'update'])->name('usuario.update');
    Route::delete('/usuario', [UsuarioController::class, 'destroy'])->name('usuario.destroy');
});

// Crud Usuário
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/users/list', [UsuarioController::class, 'list'])->name('users.list');
    Route::post('/users/search', [UsuarioController::class, 'search'])->name('users.search');
    Route::get('/users/create', [UsuarioController::class, 'createUser'])->name('users.create');
    Route::post('/users/store', [UsuarioController::class, 'storeUser'])->name('users.store');
    Route::get('/users/edit/{id}', [UsuarioController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [UsuarioController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [UsuarioController::class, 'destroyUser'])->name('users.destroy');
    Route::get('/users/pdf', [UsuarioController::class, 'relatorioUsuario'])->name('users.pdf');
});


// Filmes 
Route::middleware('auth')->group(function () {
    Route::get('/filmeuser', [FilmeController::class, 'index'])->name('filmeuser');
    Route::post('/filme/searchuser', [FilmeController::class, 'search'])->name('filme.searchuser');
    Route::get('/filme/graficogeneros', [FilmeController::class, 'graficoGeneros'])->name('filme.graficogeneros');
    Route::get('/filme/grafico/{id}', [FilmeController::class, 'grafico'])->whereNumber('id')->name('filme.graficobarras');
});

// Filmes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/filmeadmin', [FilmeController::class, 'index'])->name('filmeadmin');
    Route::get('/filme/create', [FilmeController::class, 'create'])->name('filme.create');
    Route::post('/filme/store', [FilmeController::class, 'store'])->name('filme.store');
    Route::get('/filme/edit/{id}', [FilmeController::class, 'edit'])->name('filme.edit');
    Route::put('/filme/{id}', [FilmeController::class, 'update'])->name('filme.update');
    Route::delete('/filme/{id}', [FilmeController::class, 'destroy'])->name('filme.destroy');
    Route::post('/filme/searchadmin', [FilmeController::class, 'search'])->name('filme.searchadmin');
});

// Planos 
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/planos', [PlanosController::class, 'index'])->name('planos');
    Route::get('/planos/create', [PlanosController::class, 'create'])->name('planos.create');
    Route::post('/planos/store', [PlanosController::class, 'store'])->name('planos.store');
    Route::get('/planos/edit/{id}', [PlanosController::class, 'edit'])->name('planos.edit');
    Route::put('/planos/{id}', [PlanosController::class, 'update'])->name('planos.update');
    Route::delete('/planos/{id}', [PlanosController::class, 'destroy'])->name('planos.destroy');
    Route::post('/planos/search', [PlanosController::class, 'search'])->name('planos.search');
});

Route::middleware('auth')->group(function () {
    // Avaliações
    Route::get('/avaliacao', [AvaliacaoController::class, 'index'])->name('avaliacao.index');
    Route::get('/avaliacao/create', [AvaliacaoController::class, 'create'])->name('avaliacao.create');
    Route::post('/avaliacao/store', [AvaliacaoController::class, 'store'])->name('avaliacao.store');
    Route::get('/avaliacao/edit/{id}', [AvaliacaoController::class, 'edit'])->name('avaliacao.edit');
    Route::put('/avaliacao/{id}', [AvaliacaoController::class, 'update'])->name('avaliacao.update');
    Route::delete('/avaliacao/{id}', [AvaliacaoController::class, 'destroy'])->name('avaliacao.destroy');
    Route::post('/avaliacao/search', [AvaliacaoController::class, 'search'])->name('avaliacao.search');

    // Chamados
    Route::get('/chamado', [ChamadoController::class, 'index'])->name('chamado.listchamado');
    Route::get('/chamado/create', [ChamadoController::class, 'create'])->name('chamado.create');
    Route::post('/chamado/store', [ChamadoController::class, 'store'])->name('chamado.store');
    Route::get('/chamado/edit/{id}', [ChamadoController::class, 'edit'])->name('chamado.edit');
    Route::put('/chamado/{id}', [ChamadoController::class, 'update'])->name('chamado.update');
    Route::delete('/chamado/{id}', [ChamadoController::class, 'destroy'])->name('chamado.destroy');
    Route::post('/chamado/search', [ChamadoController::class, 'search'])->name('chamado.search');
    Route::get('/chamado/pdf', [ChamadoController::class, 'relatorioChamado'])->name('chamado.pdf');
});

require __DIR__ . '/auth.php';