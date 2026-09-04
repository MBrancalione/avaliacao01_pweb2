<?php

namespace Database\Factories;

use App\Models\Catalogo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Catalogo>
 */
class AssinaturaEstadoFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => fake()->randomElement(['Ativa', 'Cancelada', 'Pendente']),
            'data_vencimento' => fake()->dateTimeBetween('now', '+1 year'),
            'codigo_transacao' => 'TRX-' . fake()->unique()->alphanumeric(10),
        ];
    }
}