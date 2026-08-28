<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\PlanosController;
use App\Http\Controllers\AvaliacaoController;


Route::get('/', function () {
    return view('main');
});

Route::get('/catalogo', [CatalogoController::class, 'index']); // Rota para a página de listagem de catálogos
Route::get('/catalogo/create', [CatalogoController::class, 'create']); // Rota para a página de criação de catálogos
Route::post('/catalogo/store', [CatalogoController::class, 'store'])->name('catalogo.store');; // Rota para a ação de armazenamento de catálogos
Route::get('/catalogo/edit/{id}', [CatalogoController::class, 'edit'])->name('catalogo.edit');; //chama o formulario puxando o id
Route::put('/catalogo/{id}', [CatalogoController::class, 'update'])->name('catalogo.update'); //somente quando for editar essa rota será chamada
Route::delete('/catalogo/{id}', [CatalogoController::class, 'destroy'])->name('catalogo.destroy');; //chama o formulario puxando o id
Route::post('/catalogo/search', [CatalogoController::class, 'search'])->name('catalogo.search');; //chama o formulario puxando o id


//Planos
Route::get('/planos', [PlanosController::class, 'index']); // Rota para a página de listagem de catálogos
Route::get('/planos/create', [PlanosController::class, 'create']); // Rota para a página de criação de catálogos
Route::post('/planos/store', [PlanosController::class, 'store'])->name('planos.store');; // Rota para a ação de armazenamento de catálogos
Route::get('/planos/edit/{id}', [PlanosController::class, 'edit'])->name('planos.edit');; //chama o formulario puxando o id
Route::put('/planos/{id}', [PlanosController::class, 'update'])->name('planos.update'); //somente quando for editar essa rota será chamada
Route::delete('/planos/{id}', [PlanosController::class, 'destroy'])->name('planos.destroy');; //chama o formulario puxando o id
Route::post('/planos/search', [PlanosController::class, 'search'])->name('planos.search');; //chama o formulario puxando o id

//avaliacao
Route::get('/avaliacao', [AvaliacaoController::class, 'index']); // Rota para a página de listagem de catálogos
Route::get('/avaliacao/create', [AvaliacaoController::class, 'create']); // Rota para a página de criação de catálogos
Route::post('/avaliacao/store', [AvaliacaoController::class, 'store'])->name('avaliacao.store');; // Rota para a ação de armazenamento de catálogos
Route::get('/avaliacao/edit/{id}', [AvaliacaoController::class, 'edit'])->name('avaliacao.edit');; //chama o formulario puxando o id
Route::put('/avaliacao/{id}', [AvaliacaoController::class, 'update'])->name('avaliacao.update'); //somente quando for editar essa rota será chamada
Route::delete('/avaliacao/{id}', [AvaliacaoController::class, 'destroy'])->name('avaliacao.destroy');; //chama o formulario puxando o id
Route::post('/avaliacao/search', [AvaliacaoController::class, 'search'])->name('avaliacao.search');; //chama o formulario puxando o id
