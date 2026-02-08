<?php

namespace Tests\Feature\Subscription;

use App\Enums\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_サブスクを登録できる(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('subscriptions.store'), [
            'subscription_name' => 'Spotify',
            'category' => Category::ENTERTAINMENT->value,
            'amount' => 980,
            'billing_day' => 1,
            'status' => 'active',
        ]);

        $response->assertRedirect(route('subscriptions.index'));
        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'subscription_name' => 'Spotify',
            'amount' => 980,
        ]);
    }

    public function test_名前が空だとバリデーションエラー(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('subscriptions.store'), [
            'subscription_name' => '',
            'category' => Category::ENTERTAINMENT->value,
            'amount' => 980,
            'billing_day' => 1,
        ]);

        $response->assertSessionHasErrors('subscription_name');
    }

    public function test_金額がマイナスだとバリデーションエラー(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('subscriptions.store'), [
            'subscription_name' => 'Netflix',
            'category' => Category::ENTERTAINMENT->value,
            'amount' => -500,
            'billing_day' => 15,
        ]);

        $response->assertSessionHasErrors('amount');
    }

    public function test_請求日が1未満だとバリデーションエラー(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('subscriptions.store'), [
            'subscription_name' => 'Netflix',
            'category' => Category::ENTERTAINMENT->value,
            'amount' => 1980,
            'billing_day' => 0,
        ]);

        $response->assertSessionHasErrors('billing_day');
    }

    public function test_請求日が28より大きいとバリデーションエラー(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('subscriptions.store'), [
            'subscription_name' => 'Netflix',
            'category' => Category::ENTERTAINMENT->value,
            'amount' => 1980,
            'billing_day' => 32,
        ]);

        $response->assertSessionHasErrors('billing_day');
    }
}
