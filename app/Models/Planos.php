<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planos extends Model
{
    public $timestamps = false; //para criar os campos created_at e updated_at
    protected $fillable = [
        'nome_plano',
        'preco_mensal',
        'limite_telas',
        'resolucao_max',
    ];

}


