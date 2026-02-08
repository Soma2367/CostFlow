<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\Category;
use App\Enums\SubscriptionStatus;
use App\Models\User;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
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
            'subscription_name' => fake()->randomElement(['Netflix', 'Spotify', 'Adobe CC', 'YouTube Premium', 'Amazon Prime']),
            'category' => fake()->randomElement(Category::cases())->value,
            'amount' => fake()->randomElement([980, 1480, 1980, 2500, 3000]),
            'billing_day' => fake()->numberBetween(1, 28),
            'status' => SubscriptionStatus::ACTIVE->value,
            'memo' => fake()->optional()->sentence(),
        ];
    }
    /**
     * サブスクが一時停止状態
     */
    public function paused(): static
    {
        return $this->state(fn() => [
            'status' => SubscriptionStatus::PAUSED->value,
        ]);
    }
    /**
     * サブスクが解約状態
     */
    public function cancelled(): static
    {
        return $this->state(fn() => [
            'status' => SubscriptionStatus::CANCELLED->value,
        ]);
    }
}
