<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'assinaturaestado_id', // Adiciona o campo assinaturaestado_id ao fillable
        'is_admin', // Adiciona o campo is_admin ao fillable
        'foto_perfil', // Adiciona o campo foto_perfil ao fillable
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'assinaturaestado_id' => 'integer',
            'is_admin' => 'boolean', // Garante que true/false funcione perfeitamente no banco
        ];
    }
    //indica que User possui um atributo em assinatura estado, retornando esse objeto como atributo do usuário; relação de chave estrangeira
    public function assinaturaEstado()
    {
        return $this->belongsTo(AssinaturaEstado::class, 'assinaturaestado_id', 'id');
    }

    // Relacionamento 1:N: Um usuário possui muitos chamados
    public function chamados()
    {
        return $this->hasMany(Chamado::class);
    }
}
