<?php

namespace Database\Factories;

use App\Models\Vendedor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class VendaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vendedor_id' => Vendedor::factory(),
            'valor' => fake()->randomFloat(2, 1, 999999),
            'data_venda' => fake()->date() . ' ' . fake()->time(),
            'comissao' => fake()->randomFloat(2, 1, 9999),
            'percentual_comissao' => fake()->randomDigitNotNull(),
        ];
    }
}
