<?php

namespace Tests\Feature\FixedCost;

use App\Enums\Category;
use App\Enums\FixedCostStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Logging\OpenTestReporting\Status;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_固定費を登録できる(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('fixed-costs.store'), [
            'cost_name' => '家賃',
            'category' => Category::LIVING->value,
            'amount' => 80000,
            'billing_day' => 25,
            'status' => FixedCostStatus::ACTIVE->value,
        ]);

        $response->assertRedirect(route('fixed-costs.index'));
        $this->assertDatabaseHas('fixed_costs', [
            'user_id' => $user->id,
            'cost_name' => '家賃',
            'amount' => 80000,
        ]);
    }

    public function test_名前が空だとバリデーションエラー(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('fixed-costs.store'), [
            'cost_name' => '',
            'category' => Category::LIVING->value,
            'amount' => 80000,
            'billing_day' => 25,
        ]);

        $response->assertSessionHasErrors('cost_name');
    }

    public function test_金額がマイナスだとバリデーションエラー(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('fixed-costs.store'), [
            'cost_name' => '家賃',
            'category' => Category::LIVING->value,
            'amount' => -1000,
            'billing_day' => 25,
        ]);

        $response->assertSessionHasErrors('amount');
    }
}
