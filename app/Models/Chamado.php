<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chamado extends Model
{
    use HasFactory; 
    public $timestamps = false; 
    protected $fillable = [
        'titulo',
        'descricao',
        'status',
        'data_criacao',
        'data_encerramento',
        'user_id',
    ];

    // Relacionamento 1:N inverso: O chamado pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
