<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\FilmeFactory;

class Filme extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'poster',
        'titulo',
        'sinopse',
        'genero_filme',
        'ano',
        'classificacao',
    ];


    protected $casts = [
        'genero_filme' => 'integer',
    ];

    public function GeneroFilme()
    {
        return $this->belongsTo(GeneroFilme::class, 'genero_filme', 'id');
    }
    public function getUrlPosterAttribute()
{
    if (!$this->poster) return null;
    return str_starts_with($this->poster, 'http') ? $this->poster : asset('storage/' . $this->poster);
}

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class);
    }
}
