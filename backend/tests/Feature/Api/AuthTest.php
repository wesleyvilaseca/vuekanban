<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * test validation auth
     *
     * @return void
     */
    public function testValidationAuth()
    {
        $response = $this->postJson('/api/v1/auth/token');
        $response->assertStatus(422);
    }

    /**
     * Test Auth with fake user
     *
     * @return void
     */
    public function testAuthClientFake()
    {
        $payload = [
            'email' => 'fakeemail@eti.com.br',
            'password' => '1232131',
            'device_name' => Str::random(10),
        ];

        $response = $this->postJson('/api/v1/auth/token', $payload);

        $response->assertStatus(404)
            ->assertExactJson([
                'message' => trans('messages.invalid_credentials')
            ]);
    }

    /**
     * Test Auth Success
     *
     * @return void
     */
    public function testAuthSuccess()
    {
        $user = User::factory()->create();

        $payload = [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => Str::random(10),
        ];

        $response = $this->postJson('/api/v1/auth/token', $payload);
        $response->assertStatus(200)->assertJsonStructure(['token']);
    }

    /**
     * Error Get Me
     *
     * @return void
     */
    public function testErrorGetMe()
    {
        $response = $this->getJson('/api/v1/auth/me');
        $response->assertStatus(401);
    }

    /**
     * Get Me success
     *
     * @return void
     */
    public function testGetMe()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $response = $this->getJson('/api/v1/auth/me', [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(200)
            ->assertExactJson([
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ]);
    }

    /**
     * Logout fail
     *
     * @return void
     */
    public function testLogoutFail()
    {
        $fake_token = '123456asdfgfgADASDFA';

        $response = $this->postJson('/api/v1/auth/logout', [], [
            'Authorization' => "Bearer {$fake_token}",
        ]);
        $response->assertStatus(401);
    }

    /**
     * Logout success
     *
     * @return void
     */
    public function testLogout()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $response = $this->postJson('/api/v1/auth/logout', [], [
            'Authorization' => "Bearer {$token}",
        ]);
        $response->assertStatus(204);
    }
}