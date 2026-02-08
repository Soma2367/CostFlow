<?php

namespace Tests\Feature\FixedCost;

use App\Models\FixedCost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    public function test_固定費を削除できる(): void
    {
        $user = User::factory()->create();
        $fixedCost = FixedCost::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->delete(route('fixed-costs.destroy', $fixedCost));

        $response->assertRedirect(route('fixed-costs.index'));
        $this->assertDatabaseMissing('fixed_costs', [
            'id' => $fixedCost->id,
        ]);
    }

    public function test_他ユーザーの固定費は削除できない(): void
    {
        $me = User::factory()->create();
        $other = User::factory()->create();
        $fixedCost = FixedCost::factory()->create([
            'user_id' => $other->id,
        ]);

        $response = $this->actingAs($me)->delete(route('fixed-costs.destroy', $fixedCost));

        $response->assertForbidden();
    }
}
