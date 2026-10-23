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

    protected $casts = [
        'data_criacao' => 'datetime',
        'data_encerramento' => 'datetime',
    ];

    // Relacionamento 1:N
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
