<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Hasfactory;
use Database\Factories\CatalogoFactory;

class Catalogo extends Model
{
    use HasFactory; 
    public $timestamps = false; 
    protected $fillable = [
        'url_poster',
        'titulo',
        'sinopse',
        'genero',
        'ano',
        'classificacao',
    ];
}
