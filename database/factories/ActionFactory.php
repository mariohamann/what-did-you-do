<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Action>
 */
class ActionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'description' => $this->faker->paragraph(1),
            'user_id' => random_int(1, 302),
            'category_id' => random_int(1, 5),
            'archived_at' => $this->faker->boolean(7) ? $this->faker->dateTimeBetween('-9 months', '-1 day') : null,
        ];
    }
}