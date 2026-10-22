<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GeneroFilme extends Model
{
    use HasFactory;

    protected $table = 'genero_filmes';

    protected $fillable = [
        'genero_filme',
    ];

    // Um gênero pode estar associado a vários itens do catálogo
    public function filmes(): HasMany
    {
        return $this->hasMany(Filme::class, 'genero_filme_id'); //mais de um hasmany
    }
}