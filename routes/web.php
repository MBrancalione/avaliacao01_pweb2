<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogoController;

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

