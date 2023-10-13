<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'password' => 'test123',
        ]);
    }

    public function test_login(): void
    {
        $response = $this->post('/api/login', [
            'email' => $this->user->email,
            'password' => 'test123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
    }

    public function test_me(): void
    {

        $response = $this->actingAs($this->user)->get('/api/me');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'email' => $this->user->email,
            'name' => $this->user->name,
        ]);
    }

    public function test_logout(): void
    {
        $response = $this->actingAs($this->user)->post('/api/logout');

        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => 'success']);
    }
}
