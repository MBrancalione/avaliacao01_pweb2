<?php

namespace Database\Factories;

use App\Models\Chamado;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<Chamado>
 */
class ChamadoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'titulo' => fake()->sentence(4),
            'descricao' => fake()->paragraph(),
            'status' => fake()->randomElement(['Aberto', 'Em andamento', 'Fechado']),
            'data_criacao' => fake()->dateTimeBetween('-1 month', 'now'),
            'data_encerramento' => fake()->optional()->dateTimeBetween('now', '+1 month'),
        ];
    }
}
