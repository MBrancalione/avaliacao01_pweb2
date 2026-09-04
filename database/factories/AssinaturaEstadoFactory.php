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
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->randomElement(['Ativa', 'Cancelada', 'Pendente']),
        ];
    }
}