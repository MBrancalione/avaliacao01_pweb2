<?php

namespace Database\Factories;

use App\Models\Planos;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome_plano' => fake()->randomElement(['Plano Básico', 'Plano Premium', 'Plano VIP']),
            'preco_mensal' => fake()->randomFloat(2, 10, 100),
            'limite_telas' => fake()->numberBetween(2, 6),
            'resolucao_max' => fake()->randomElement([720, 1080, 1440]),
        ];
    }
}
