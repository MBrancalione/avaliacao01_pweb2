<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Hasfactory;
use Database\Factories\AvaliacaoFactory;

class Avaliacao extends Model
{
    use HasFactory; //has factory serve para chamar a factory
    public $timestamps = false; //para não criar o timestamps created_at e updated_at, estav dando interferencia
    protected $fillable = [
        'nota',
        'comentario',
        'spoiler',
    ];

    //protect - apenas a classe pode acessar
    protected $table = 'avaliacao'; 
    //dei uma pesquisada e vi q o laravel considera um s no final da palavra quando ela termina em vogal, dai tem q colocar isso p n dar erro
}
