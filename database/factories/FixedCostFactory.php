<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\Category;
use App\Enums\FixedCostStatus;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FixedCost>
 */
class FixedCostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'cost_name' => fake()->randomElement(['家賃', '電気代', '水道代', 'ガス代', 'Wi-Fi', '駐車場代']),
            'category' => fake()->randomElement(Category::cases())->value,
            'amount' => fake()->randomElement([5000, 8000, 10000, 50000, 80000]),
            'billing_day' => fake()->numberBetween(1, 28),
            'status' => FixedCostStatus::ACTIVE->value,
            'memo' => fake()->optional()->sentence(),
        ];
    }

    /**
     * 固定費が無効状態
     */
    public function inactive(): static
    {
        return $this->state(fn() => [
            'status' => FixedCostStatus::INACTIVE->value,
        ]);
    }
}
