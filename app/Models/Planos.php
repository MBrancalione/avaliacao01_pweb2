<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Hasfactory;
use Database\Factories\CatalogoFactory;

class Planos extends Model
{
        use Hasfactory; //para usar a factory

    public $timestamps = false; //para criar os campos created_at e updated_at
    protected $fillable = [
        'nome_plano',
        'preco_mensal',
        'limite_telas',
        'resolucao_max',
    ];

}


