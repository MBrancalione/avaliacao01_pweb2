<?php

namespace Database\Factories;

use App\Models\Avaliacao;
use App\Models\Catalogo;
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
            'catalogo_id' => \App\Models\Catalogo::All()->random()->id,
            'nota' => fake()->randomElement(['5', '4', '3', '2', '1']),
            'comentario' => fake()->randomElement(['Muito bom!', 'Boa', 'Regular', 'Ruim', 'Péssimo']),
            'spoiler' => fake()->boolean(),
            'user_id' => \App\Models\User::All()->random()->id,
        ];
    }
}
