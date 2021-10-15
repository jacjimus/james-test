<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * Test Companies List
     *
     * @return void
     */
    public function testCategoryList()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')
            ->getJson('/api/category');

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => true,
            ]);
    }
}
