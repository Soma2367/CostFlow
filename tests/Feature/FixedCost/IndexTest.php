<?php

namespace Tests\Feature\FixedCost;

use App\Models\FixedCost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_ログイン済みユーザーは一覧を表示できる(): void
    {
        $user = User::factory()->create();
        $fixedCost = FixedCost::factory()->create([
            'user_id' => $user->id,
            'cost_name' => '家賃',
        ]);

        $response = $this->actingAs($user)->get(route('fixed-costs.index'));

        $response->assertStatus(200);
        $response->assertSee('家賃');
    }

    public function test_未ログインはログイン画面にリダイレクトされる(): void
    {
        $response = $this->get(route('fixed-costs.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_他ユーザーの固定費は表示されない(): void
    {
        $me = User::factory()->create();
        $other = User::factory()->create();

        FixedCost::factory()->create([
            'user_id' => $other->id,
            'cost_name' => '他人の家賃',
        ]);

        $response = $this->actingAs($me)->get(route('fixed-costs.index'));

        $response->assertDontSee('他人の家賃');
    }
}
