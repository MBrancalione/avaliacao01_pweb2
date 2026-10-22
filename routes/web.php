<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\PlanosController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\ChamadoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rotas de listagem e pesquisa de utilizadores (Relacionamento 1:1)
    Route::get('/users/list', [ProfileController::class, 'list'])->name('users.list');
    Route::post('/users/search', [ProfileController::class, 'search'])->name('users.search');
});

Route::get('/main', function () {
    return view('main');
})->name('main');

// ==========================================
// CATÁLOGO (Usa o método index e search unificados)
// ==========================================
Route::get('/catalogoadmin', [CatalogoController::class, 'index'])->name('catalogoadmin'); 
Route::get('/catalogouser', [CatalogoController::class, 'index'])->name('catalogouser'); 
Route::get('/catalogo/create', [CatalogoController::class, 'create'])->name('catalogo.create'); 
Route::post('/catalogo/store', [CatalogoController::class, 'store'])->name('catalogo.store'); 
Route::get('/catalogo/edit/{id}', [CatalogoController::class, 'edit'])->name('catalogo.edit'); 
Route::put('/catalogo/{id}', [CatalogoController::class, 'update'])->name('catalogo.update'); 
Route::delete('/catalogo/{id}', [CatalogoController::class, 'destroy'])->name('catalogo.destroy'); 
Route::post('/catalogo/searchadmin', [CatalogoController::class, 'search'])->name('catalogo.searchadmin');
Route::post('/catalogo/searchuser', [CatalogoController::class, 'search'])->name('catalogo.searchuser'); 

// ==========================================
// CHAMADOS
// ==========================================
Route::get('/chamado', [ChamadoController::class, 'index'])->name('chamado.list'); 
Route::get('/chamado/create', [ChamadoController::class, 'create'])->name('chamado.create'); 
Route::post('/chamado/store', [ChamadoController::class, 'store'])->name('chamado.store'); 
Route::get('/chamado/edit/{id}', [ChamadoController::class, 'edit'])->name('chamado.edit'); 
Route::put('/chamado/{id}', [ChamadoController::class, 'update'])->name('chamado.update'); 
Route::delete('/chamado/{id}', [ChamadoController::class, 'destroy'])->name('chamado.destroy'); 
Route::post('/chamado/search', [ChamadoController::class, 'search'])->name('chamado.search'); // Corrigido de searchuser e corrigido o typo 'serarch'

// ==========================================
// PLANOS
// ==========================================
Route::get('/planos', [PlanosController::class, 'index'])->name('planos');
Route::get('/planos/create', [PlanosController::class, 'create'])->name('planos.create'); 
Route::post('/planos/store', [PlanosController::class, 'store'])->name('planos.store');
Route::get('/planos/edit/{id}', [PlanosController::class, 'edit'])->name('planos.edit');
Route::put('/planos/{id}', [PlanosController::class, 'update'])->name('planos.update'); 
Route::delete('/planos/{id}', [PlanosController::class, 'destroy'])->name('planos.destroy');
Route::post('/planos/search', [PlanosController::class, 'search'])->name('planos.search');

// ==========================================
// AVALIAÇÕES
// ==========================================
Route::get('/avaliacao', [AvaliacaoController::class, 'index'])->name('avaliacao.index'); 
Route::get('/avaliacao/create', [AvaliacaoController::class, 'create'])->name('avaliacao.create'); 
Route::post('/avaliacao/store', [AvaliacaoController::class, 'store'])->name('avaliacao.store');
Route::get('/avaliacao/edit/{id}', [AvaliacaoController::class, 'edit'])->name('avaliacao.edit');
Route::put('/avaliacao/{id}', [AvaliacaoController::class, 'update'])->name('avaliacao.update'); 
Route::delete('/avaliacao/{id}', [AvaliacaoController::class, 'destroy'])->name('avaliacao.destroy');
Route::post('/avaliacao/search', [AvaliacaoController::class, 'search'])->name('avaliacao.search');


Route::get('generate-pdf', [ChamadoController::class, 'generatePDF']);
require __DIR__ . '/auth.php';