<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Avaliacao extends Model
{
    use HasFactory; //has factory serve para chamar a factory
    public $timestamps = false; //para não criar o timestamps created_at e updated_at, estav dando interferencia
    protected $fillable = [
        'nota',
        'comentario',
        'spoiler',
        'filme_id',
        'user_id'//manter o relaconemto com filme, para poder salvar a avaliação de um filme específico
    ];

    //quando tiver chave estrangeira e os campos forem diferentes de string tem que add esse cast
    protected $cast = [
        'user_id' => 'integer',
        'filme_id' => 'integer'
    ];

    public function filme()
    {
        return $this->belongsTo(Filme::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //protect - apenas a classe pode acessar
    protected $table = 'avaliacao';
    //dei uma pesquisada e vi q o laravel considera um s no final da palavra quando ela termina em vogal, dai tem q colocar isso p n dar erro
}
