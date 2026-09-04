<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\PlanosController;
use App\Http\Controllers\AvaliacaoController;

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
});

Route::get('/main', function () {
    return view('main');
})->name('main');

//name é como a rota será chamada dentro do código, chamando o controller responsável e qual método será utilizado
Route::get('/catalogoadmin', [CatalogoController::class, 'indexadmin'])->name('catalogoadmin'); //get exibe uma página de dados
Route::get('/catalogouser', [CatalogoController::class, 'indexuser'])->name('catalogouser'); 
Route::get('/catalogo/create', [CatalogoController::class, 'create'])->name('catalogo.create'); 
Route::post('/catalogo/store', [CatalogoController::class, 'store'])->name('catalogo.store'); //post envia dados do formulario
Route::get('/catalogo/edit/{id}', [CatalogoController::class, 'edit'])->name('catalogo.edit'); 
Route::put('/catalogo/{id}', [CatalogoController::class, 'update'])->name('catalogo.update'); //put atualiza os dados do formulario
Route::delete('/catalogo/{id}', [CatalogoController::class, 'destroy'])->name('catalogo.destroy'); //delete remove os dados do formulario
Route::post('/catalogo/searchadmin', [CatalogoController::class, 'searchadmin'])->name('catalogo.searchadmin');
Route::post('/catalogo/searchuser', [CatalogoController::class, 'searchuser'])->name('catalogo.searchuser'); 


//Planos
Route::get('/planos', [PlanosController::class, 'index'])->name('planos');
Route::get('/planos/create', [PlanosController::class, 'create']); 
Route::post('/planos/store', [PlanosController::class, 'store'])->name('planos.store');
Route::get('/planos/edit/{id}', [PlanosController::class, 'edit'])->name('planos.edit');
Route::put('/planos/{id}', [PlanosController::class, 'update'])->name('planos.update'); 
Route::delete('/planos/{id}', [PlanosController::class, 'destroy'])->name('planos.destroy');
Route::post('/planos/search', [PlanosController::class, 'search'])->name('planos.search');

//avaliacao
Route::get('/avaliacao', [AvaliacaoController::class, 'index']); 
Route::get('/avaliacao/create', [AvaliacaoController::class, 'create'])->name('avaliacao.create'); 
Route::post('/avaliacao/store', [AvaliacaoController::class, 'store'])->name('avaliacao.store');
Route::get('/avaliacao/edit/{id}', [AvaliacaoController::class, 'edit'])->name('avaliacao.edit');
Route::put('/avaliacao/{id}', [AvaliacaoController::class, 'update'])->name('avaliacao.update'); 
Route::delete('/avaliacao/{id}', [AvaliacaoController::class, 'destroy'])->name('avaliacao.destroy');
Route::post('/avaliacao/search', [AvaliacaoController::class, 'search'])->name('avaliacao.search');
require __DIR__ . '/auth.php';


//rota para listagem de usuarios
Route::middleware('auth')->group(function () {
    Route::get('/users/list', [ProfileController::class, 'list'])->name('users.list');
});
//rota para pesquisa desses usuarios
Route::middleware('auth')->group(function () {
    Route::post('/users/search', [ProfileController::class, 'search'])->name('users.search');
});

