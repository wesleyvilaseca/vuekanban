<?php

namespace Tests\Feature\Api;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class BoardTest extends TestCase
{
    /**
     * test create board success
     *
     * @return void
     */
    public function testCreateBoardSuccess()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $project = Project::factory()->create();

        $payload = [
            "title" => "title test",
            "project_id" => $project->id
        ];

        $response = $this->postJson('/api/v1/board', $payload, [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(200);
    }

    /**
     * test create board fail fake projectId
     *
     * @return void
     */
    // public function testCreateBoardFailProjectId()
    // {
    //     $user = User::factory()->create();
    //     $token = $user->createToken(Str::random(10))->plainTextToken;

    //     $payload = [
    //         "title" => "title test",
    //         "project_id" => 10
    //     ];

    //     $response = $this->postJson('/api/v1/board', $payload, [
    //         'Authorization' => "Bearer {$token}",
    //     ]);

    //     $response->assertStatus(400);
    // }
}
