<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(),
            'note' => fake()->paragraph(),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'is_completed' => fake()->boolean()
        ];
    }

    public function completed()
    {
        return $this->state(fn (array $attributes) => [
            'is_completed' => true
        ]);
    }

    public function uncompleted()
    {
        return $this->state(fn (array $attributes) => [
            'is_completed' => false,
        ]);
    }
}
