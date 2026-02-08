<?php

namespace Tests\Feature\Admin;

use App\Models\FixedCost;
use App\Models\Income;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_管理画面が表示される(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admins.index'));

        $response->assertStatus(200);
    }

    public function test_未ログインはログイン画面にリダイレクトされる(): void
    {
        $response = $this->get(route('admins.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_サブスクと固定費のデータが表示される(): void
    {
        $user = User::factory()->create();

        Subscription::factory()->create([
            'user_id' => $user->id,
            'subscription_name' => 'Netflix',
            'amount' => 1980,
        ]);

        FixedCost::factory()->create([
            'user_id' => $user->id,
            'cost_name' => '家賃',
            'amount' => 80000,
        ]);

        $response = $this->actingAs($user)->get(route('admins.index'));

        $response->assertStatus(200);
        $response->assertSee('Netflix');
        $response->assertSee('家賃');
    }

    public function test_データがゼロ件でもエラーにならない(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admins.index'));

        $response->assertStatus(200);
    }

    public function test_他ユーザーのデータは表示されない(): void
    {
        $me = User::factory()->create();
        $other = User::factory()->create();

        Subscription::factory()->create([
            'user_id' => $other->id,
            'subscription_name' => '他人のSpotify',
        ]);

        FixedCost::factory()->create([
            'user_id' => $other->id,
            'cost_name' => '他人の家賃',
        ]);

        $response = $this->actingAs($me)->get(route('admins.index'));

        $response->assertDontSee('他人のSpotify');
        $response->assertDontSee('他人の家賃');
    }
}
