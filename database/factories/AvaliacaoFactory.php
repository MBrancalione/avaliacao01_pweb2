<?php

namespace Database\Factories;

use App\Models\Avaliacao;
use Illuminate\Database\Eloquent\Factories\Factory;

class AvaliacaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nota' => fake()->randomElement(['5', '4', '3', '2', '1']),
            'comentario' => fake()->randomElement(['Muito bom!', 'Boa', 'Regular', 'Ruim', 'Péssimo']),
            'spoiler' => fake()->randomElement(['True', 'False']),
        ];
    }
}
