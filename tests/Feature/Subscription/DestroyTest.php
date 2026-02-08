<?php

namespace Tests\Feature\Subscription;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    public function test_サブスクを削除できる(): void
    {
        $user = User::factory()->create();
        $subscription = Subscription::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->delete(route('subscriptions.destroy', $subscription));

        $response->assertRedirect(route('subscriptions.index'));
        $this->assertDatabaseMissing('subscriptions', [
            'id' => $subscription->id,
        ]);
    }

    public function test_他ユーザーのサブスクは削除できない(): void
    {
        $me = User::factory()->create();
        $other = User::factory()->create();
        $subscription = Subscription::factory()->create([
            'user_id' => $other->id,
        ]);

        $response = $this->actingAs($me)->delete(route('subscriptions.destroy', $subscription));

        $response->assertForbidden();
    }
}
