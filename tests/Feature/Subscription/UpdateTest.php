<?php

namespace Tests\Feature\Subscription;

use App\Enums\Category;
use App\Enums\SubscriptionStatus;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_サブスクを更新できる(): void
    {
        $user = User::factory()->create();
        $subscription = Subscription::factory()->create([
            'user_id' => $user->id,
            'subscription_name' => 'Netflix',
            'amount' => 1980,
        ]);

        $response = $this->actingAs($user)->put(route('subscriptions.update', $subscription), [
            'subscription_name' => 'Netflix Premium',
            'category' => Category::ENTERTAINMENT->value,
            'amount' => 2480,
            'billing_day' => 15,
            'status' => 'active',
        ]);

        $response->assertRedirect(route('subscriptions.index'));
        $this->assertDatabaseHas('subscriptions', [
            'id' => $subscription->id,
            'subscription_name' => 'Netflix Premium',
            'amount' => 2480,
        ]);
    }

    public function test_他ユーザーのサブスクは更新できない(): void
    {
        $me = User::factory()->create();
        $other = User::factory()->create();
        $subscription = Subscription::factory()->create([
            'user_id' => $other->id,
        ]);

        $response = $this->actingAs($me)->put(route('subscriptions.update', $subscription), [
            'subscription_name' => 'ハック',
            'category' => Category::ENTERTAINMENT->value,
            'amount' => 0,
            'billing_day' => 1,
            'status' => SubscriptionStatus::ACTIVE->value,
        ]);

        $response->assertForbidden();
    }
}
