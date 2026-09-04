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
}