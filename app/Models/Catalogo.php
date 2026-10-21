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
        'poster',
        'titulo',
        'sinopse',
        'genero',
        'ano',
        'classificacao',
        'genero_filme_id',
    ];

    
    protected $cast = [
        'genero_filme_id' => 'integer',
    ];

        public function GeneroFilme()
    {
        return $this->belongsTo(GeneroFilme::class, 'genero_filme_id', 'id');
    }

    // Se um catálogo tiver avaliações, podemos adicionar a relação aqui futuramente:
    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class);
    }
}
