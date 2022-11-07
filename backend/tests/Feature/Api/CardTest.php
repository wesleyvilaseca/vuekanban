<?php

namespace Tests\Feature\Api;

use App\Models\Board;
use App\Models\Card;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class CardTest extends TestCase
{
    /**
     * test create card success
     *
     * @return void
     */
    public function testCreateCardSuccess()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $board = Board::factory()->create();

        $payload = [
            "title" => "title test",
            "project_id" => $board->project_id,
            'description' => ''
        ];

        $response = $this->postJson('/api/v1/card', $payload, [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(200);
    }

    /**
     * test create card fail FakeProjectId
     *
     * @return void
     */
    public function testCreateCardFailFakeProjectId()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $payload = [
            "title" => "title test",
            "project_id" => '213213213213321',
            'description' => ''
        ];

        $response = $this->postJson('/api/v1/card', $payload, [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(400);
    }

    /**
     * test create card fail Required Params
     *
     * @return void
     */
    public function testCreateCardFailRequiredParams()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $payload = [
            "title" => "",
            "project_id" => '',
            'description' => ''
        ];

        $response = $this->postJson('/api/v1/card', $payload, [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(400);
    }

    /**
     * test create card fail Required Params
     *
     * @return void
     */
    public function testEditCardSuccess()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $card = Card::factory()->create();

        $payload = [
            'title' => 'edite title',
            'board_id' => $card->board_id,
            'description' => '',
            'index' => 0,
        ];

        $response = $this->postJson("/api/v1/card/{$card->id}/edit", $payload, [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(202);
    }

    /**
     * test create card fail Required Params
     *
     * @return void
     */
    public function testEditCardFailRequiredParams()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $card = Card::factory()->create();

        $payload = [
            'title' => '',
            'board_id' => '',
            'description' => '',
            'index' => 0,
        ];

        $response = $this->postJson("/api/v1/card/{$card->id}/edit", $payload, [
            'Authorization' => "Bearer {$token}",
        ]);

        //422 é nativo de erro do request do laravel
        $response->assertStatus(422);
    }

    /**
     * test create card fail fake card id
     *
     * @return void
     */
    public function testEditCardFailFakeCardId()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $fake_cardid = 21231;
        $payload = [
            'title' => 'edite title',
            'board_id' => 13132123,
            'description' => '',
            'index' => 0,
        ];

        $response = $this->postJson("/api/v1/card/{$fake_cardid}/edit", $payload, [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(404);
    }

    /**
     * test create card fail fake board id
     *
     * @return void
     */
    public function testEditCardFailFakeBoardId()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $card = Card::factory()->create();

        $payload = [
            'title' => 'edite title',
            'board_id' => 13132123,
            'description' => '',
            'index' => 0,
        ];

        $response = $this->postJson("/api/v1/card/{$card->id}/edit", $payload, [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(400);
    }

    /**
     * test create card success delete card
     *
     * @return void
     */
    public function testDeleteCardSuccess()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $card = Card::factory()->create();

        $response = $this->postJson("/api/v1/card/{$card->id}/delete", [], [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(200);
    }

    /**
     * test create card fail fakeCardId
     *
     * @return void
     */
    public function testDeleteCardFailFakeId()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $fake_cardid = 12131321;

        $response = $this->postJson("/api/v1/card/{$fake_cardid}/delete", [], [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(400);
    }
}
