<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    public $timestamps = false; //para criar os campos created_at e updated_at
    protected $fillable = [
        'nota',
        'comentario',
        'spoiler',
    ];

    protected $table = 'avaliacao'; //dei uma pesquisada e vi q o laravel considera um s no final da palavra quando ela termina em vogal, dai tem q colocar isso p n dar erro
}
