<?php

namespace Database\Factories;

use App\Models\Catalogo;
use Illuminate\Database\Eloquent\Factories\Factory;

class CatalogoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'url_poster' => 'https://picsum.photos/seed/' . $this->faker->unique()->word . '/200/300',
            'titulo' => fake()->sentence(3),
            'sinopse' => fake()->paragraph(),
            'genero' => fake()->randomElement(['Ação', 'Comédia', 'Drama', 'Sci-Fi']),
            'ano' => fake()->year(),
            'classificacao' => fake()->randomElement(['L', '10', '12', '14', '16', '18']),
        ];
    }
}
