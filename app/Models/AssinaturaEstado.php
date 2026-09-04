<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\AssinaturaEstadoFactory;

class AssinaturaEstado extends Model
{
    /** @use HasFactory<\Database\Factories\AssinaturaEstadoFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'status',
    ];

    //indica na relação que assinatura estado pertence a um usuário, retornando esse objeto como atributo do assinatura estado; relação de chave estrangeira
    public function user()
    {
        return $this->hasOne(User::class, 'assinaturaestado_id', 'id');
    }

    
}