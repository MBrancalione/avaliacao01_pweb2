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
        'assinaturaestado_id',
        'is_admin',
        'foto_perfil',
        // Campos de Endereço
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
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
            'is_admin' => 'boolean',
        ];
    }

    public function getUrlFotoAttribute()
    {
        if (!$this->foto_perfil)
            return null;
        return str_starts_with($this->foto_perfil, 'http') ? $this->foto_perfil : asset('storage/' . $this->foto_perfil);
    }

    // Relacionamento 1:1
    public function assinaturaEstado()
    {
        return $this->belongsTo(AssinaturaEstado::class, 'assinaturaestado_id', 'id');
    }

    // Relacionamento 1:N
    public function chamados()
    {
        return $this->hasMany(Chamado::class);
    }

    // Relacionamento 1:N
    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class);
    }
}