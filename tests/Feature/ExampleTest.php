<?php

namespace Tests\Feature;

use App\Models\Groups;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class ExampleTest extends TestCase
{
//    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_create_groups(): void
    {
        $payload = [
          'name' => 'Natal 2024'
        ];
        $response = $this->post('api/groups',$payload);
        $response->assertStatus(ResponseAlias::HTTP_CREATED);
    }

    public function test_add_participant_to_group_successfully()
    {
        $group = Groups::create(['name' => 'Natal 2024']);
//        $group = Groups::first();
        $payload = [
            'name' => 'julio'
        ];
        $response = $this->post('api/groups/' . $group->id . '/participants', $payload);
        $response->assertStatus(ResponseAlias::HTTP_CREATED);
    }

    public function test_generate_secret_santa_pairs_successfully()
    {
        $group = Groups::first();
        $response = $this->post('api/groups/' . $group->id . '/matches');
        $response->assertStatus(ResponseAlias::HTTP_CREATED);
    }
}
