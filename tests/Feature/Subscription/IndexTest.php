<?php

namespace Tests\Feature\Subscription;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_ログイン済みユーザーは一覧を表示できる(): void
    {
        $user = User::factory()->create();
        $subscription = Subscription::factory()->create([
            'user_id' => $user->id,
            'subscription_name' => 'Netflix',
        ]);

        $response = $this->actingAs($user)->get(route('subscriptions.index'));

        $response->assertStatus(200);
        $response->assertSee('Netflix');
    }

    public function test_未ログインはログイン画面にリダイレクトされる(): void
    {
        $response = $this->get(route('subscriptions.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_他ユーザーのサブスクは表示されない(): void
    {
        $me = User::factory()->create();
        $other = User::factory()->create();

        Subscription::factory()->create([
            'user_id' => $other->id,
            'subscription_name' => '他人のNetflix',
        ]);

        $response = $this->actingAs($me)->get(route('subscriptions.index'));

        $response->assertDontSee('他人のNetflix');
    }
}
