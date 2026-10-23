<?php

namespace Database\Factories;

use App\Models\Filme;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Filme>
 */
class GeneroFilmeFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'genero_filme' => fake()->unique()->randomElement([
                'Ação',
                'Aventura',
                'Comédia',
                'Drama',
                'Ficção Científica',
                'Terror',
                'Romance',
                'Suspense',
                'Animação',
                'Documentário',
                'Fantasia',
                'Policial',
                'Mistério',
                'Faroeste',
                'Musical'
            ]),
        ];
    }
}