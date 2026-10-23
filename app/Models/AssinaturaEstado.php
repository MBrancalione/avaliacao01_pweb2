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
        'status',
        'data_vencimento',
        'codigo_transacao',
        'user_id',
        'plano_id',
    ];

    //indica na relação que assinatura estado pertence a um usuário, retornando esse objeto como atributo do assinatura estado; relação de chave estrangeira
    public function plano()
    {
        return $this->belongsTo(Planos::class, 'plano_id', 'id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'assinaturaestado_id', 'id');
    }


}