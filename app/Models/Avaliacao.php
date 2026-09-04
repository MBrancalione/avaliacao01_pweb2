<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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

    public function catalogo()
    {
        return $this->belongsTo(Catalogo::class);
    }

    //protect - apenas a classe pode acessar
    protected $table = 'avaliacao';
    //dei uma pesquisada e vi q o laravel considera um s no final da palavra quando ela termina em vogal, dai tem q colocar isso p n dar erro
}
