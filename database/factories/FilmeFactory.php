<?php

namespace Database\Factories;

use App\Models\Filme;
use App\Models\GeneroFilme;

use Illuminate\Database\Eloquent\Factories\Factory;

class FilmeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'poster' => fake()->imageUrl(400, 600, 'movies', true),            'titulo' => fake()->sentence(3),
            'sinopse' => fake()->paragraph(2),
            'ano' => fake()->year(),
            'classificacao' => fake()->randomElement(['L', '10', '12', '14', '16', '18']),
            'genero_filme' => GeneroFilme::inRandomOrder()->first()?->id ?? GeneroFilme::factory() //cria um estado de assinatura para cada usuário criado

        ];
    }
}
