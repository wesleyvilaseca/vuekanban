<?php

namespace Tests\Feature\Api;

use App\Models\Board;
use App\Models\Project;
use App\Models\User;
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

        $response->assertStatus(201);
    }

    /**
     * test create board fail fake projectId
     *
     * @return void
     */
    public function testCreateBoardFailProjectId()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $payload = [
            "title" => "title test",
            "project_id" => 10
        ];

        $response = $this->postJson('/api/v1/board', $payload, [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(400);
    }

    /**
     * test delete board success
     *
     * @return void
     */
    public function testDeleteBoardSuccess()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $board = Board::factory()->create();

        $response = $this->postJson("/api/v1/board/{$board->id}/delete", [], [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(200);
    }


    /**
     * test delete board fail
     *
     * @return void
     */
    public function testDeleteBoardFail()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $fake_board_id = '331321311';

        $response = $this->postJson("/api/v1/board/{$fake_board_id}/delete", [], [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(400);
    }

    /**
     * test edit board success
     *
     * @return void
     */
    public function testEditBoardSuccess()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $board = Board::factory()->create();

        $payload = [
            'title' => 'title edit',
            'project_id' => $board->project_id
        ];

        $response = $this->postJson("/api/v1/board/{$board->id}/edit", $payload, [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(200);
    }

    /**
     * test edit board fail required params
     *
     * @return void
     */
    public function testEditBoardFailRequiredParams()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $board = Board::factory()->create();

        $payload = [
            'title' => '',
            'project_id' => $board->project_id
        ];

        $response = $this->postJson("/api/v1/board/{$board->id}/edit", $payload, [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(400);
    }

    /**
     * test edit board fail fake project id
     *
     * @return void
     */
    public function testEditBoardFailProjectId()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $board = Board::factory()->create();

        $payload = [
            'title' => 'edit title',
            'project_id' => '2132132113213'
        ];

        $response = $this->postJson("/api/v1/board/{$board->id}/edit", $payload, [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(400);
    }


    /**
     * test edit board fail fake board id
     *
     * @return void
     */
    public function testEditBoardFailBoardId()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $fake_board_id = '1312131';

        $response = $this->postJson("/api/v1/board/{$fake_board_id}/edit", [], [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(400);
    }
}
