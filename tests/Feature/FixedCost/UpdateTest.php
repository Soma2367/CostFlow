<?php

namespace Tests\Feature\FixedCost;

use App\Enums\Category;
use App\Models\FixedCost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_固定費を更新できる(): void
    {
        $user = User::factory()->create();
        $fixedCost = FixedCost::factory()->create([
            'user_id' => $user->id,
            'cost_name' => '家賃',
            'amount' => 80000,
        ]);

        $response = $this->actingAs($user)->put(route('fixed-costs.update', $fixedCost), [
            'cost_name' => '家賃（更新後）',
            'category' => Category::LIVING->value,
            'amount' => 85000,
            'billing_day' => 25,
            'status' => 'active',
        ]);

        $response->assertRedirect(route('fixed-costs.index'));
        $this->assertDatabaseHas('fixed_costs', [
            'id' => $fixedCost->id,
            'cost_name' => '家賃（更新後）',
            'amount' => 85000,
        ]);
    }

    public function test_他ユーザーの固定費は更新できない(): void
    {
        $me = User::factory()->create();
        $other = User::factory()->create();
        $fixedCost = FixedCost::factory()->create([
            'user_id' => $other->id,
        ]);

        $response = $this->actingAs($me)->put(route('fixed-costs.update', $fixedCost), [
            'cost_name' => 'ハック',
            'category' => Category::LIVING->value,
            'amount' => 0,
            'billing_day' => 1,
            'status' => 'active',
        ]);

        $response->assertForbidden();
    }
}
