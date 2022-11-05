<?php

namespace Tests\Feature\Api;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    /**
     * success project list
     *
     * @return void
     */
    public function testGetProjectsTest()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $header = [
            'Authorization' => "Bearer {$token}"
        ];

        $response = $this->getJson('/api/v1/projects', $header);

        $response->assertStatus(200);
    }

    /**
     * fail project list
     *
     * @return void
     */
    public function testGetProjectsTestError()
    {
        $fake_token = '1234561234$#@!';

        $response = $this->getJson('/api/v1/projects', [
            'Authorization' => "Bearer {$fake_token}",
        ]);

        $response->assertStatus(401);
    }

    /**
     * create project success
     *
     * @return void
     */
    public function testCreateProjectTest()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $payload = [
            "name" => "Fake name",
            "description" => "Fake description"
        ];

        $response = $this->postJson('/api/v1/project', $payload, [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(200);
    }

    /**
     * create project unauthorized error
     *
     * @return void
     */
    public function testCreateProjectTestUnathorizedError()
    {
        $fake_token = '1234561234$#@!';

        $payload = [
            "name" => "Fake name",
            "description" => "Fake description"
        ];

        $response = $this->postJson('/api/v1/project', $payload, [
            'Authorization' => "Bearer {$fake_token}",
        ]);

        $response->assertStatus(401);
    }


    /**
     * create project required params error
     *
     * @return void
     */
    public function testCreateProjectTestRequiredParamsError()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $payload = [
            "name" => "",
            "description" => "Fake description"
        ];

        $response = $this->postJson('/api/v1/project', $payload, [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(422);
    }

    /**
     * edit project required params error
     *
     * @return void
     */
    public function testEditProjectSuccess()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $project = Project::factory()->create();

        $payload = [
            "name" => "Edit name teste",
            "description" => "fake desc"
        ];

        $response = $this->postJson("/api/v1/project/{$project->id}/edit", $payload, [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(200);
    }


    /**
     * delete project success
     *
     * @return void
     */
    public function testDeleteProjectSuccess()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $project = Project::factory()->create();

        $response = $this->postJson("/api/v1/project/{$project->id}/delete", [], [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(200);
    }


    /**
     * delete project fail idProject Fake
     *
     * @return void
     */
    public function testDeleteProjectFailIdProjectFake()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $idProjectFake = 10;

        $response = $this->postJson("/api/v1/project/{$idProjectFake}/delete", [], [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(400);
    }
}