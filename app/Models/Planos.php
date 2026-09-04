<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Hasfactory;
use Database\Factories\PlanosFactory;

class Planos extends Model
{
    use HasFactory; 
    public $timestamps = false; 
    protected $fillable = [
        'nome_plano',
        'preco_mensal',
        'limite_telas',
        'resolucao_max',
    ];

}


