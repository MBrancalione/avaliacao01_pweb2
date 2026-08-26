<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalogo extends Model
{
    public $timestamps = false; //para criar os campos created_at e updated_at
    protected $fillable = [
        'titulo',
        'sinopse',
        'genero',
        'ano',
        'classificacao',
    ];
}
