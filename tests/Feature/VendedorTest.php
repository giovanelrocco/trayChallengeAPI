<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vendedor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VendedorTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function testGetVendedores(): void
    {
        Vendedor::factory(10)->create();

        $response = $this->actingAs($this->user)->get('/api/vendedor');

        $response->assertStatus(200);
        $response->assertJsonIsArray();
        $response->assertJsonCount(10);
    }

    public function testGetVendedor(): void
    {
        $vendedor = Vendedor::factory()->create();

        $response = $this->actingAs($this->user)->get('/api/vendedor/' . $vendedor->id);

        $response->assertStatus(200);
        $response->assertJsonIsObject();
        $response->assertExactJson($vendedor->toArray());
    }

    public function testGetVendedorNotFound(): void
    {
        $response = $this->actingAs($this->user)->get('/api/vendedor/100000000');

        $response->assertStatus(404);
        $response->assertSeeText('Vendedor não encontrado.');
    }

    public function testPostVendedor(): void
    {
        $response = $this->actingAs($this->user)->post('/api/vendedor', [
            'nome' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
        ]);

        $response->assertCreated();
    }

    public function testPostVendedorWithoutName(): void
    {
        $response = $this->actingAs($this->user)->post('/api/vendedor', [
            'nome' => '',
            'email' => fake()->unique()->safeEmail(),
        ]);

        $response->assertStatus(422);
        $response->assertExactJson(['nome' => ['The nome field is required.']]);
    }

    public function testPostVendedorWithoutEmail(): void
    {
        $response = $this->actingAs($this->user)->post('/api/vendedor', [
            'nome' => fake()->name(),
            'email' => '',
        ]);

        $response->assertStatus(422);
        $response->assertExactJson(['email' => ['The email field is required.']]);
    }

    public function testPostVendedorDuplicatedEmail(): void
    {
        $vendedor = Vendedor::factory()->create();

        $response = $this->actingAs($this->user)->post('/api/vendedor', [
            'nome' => $vendedor->nome,
            'email' => $vendedor->email,
        ]);

        $response->assertStatus(422);
        $response->assertExactJson(['email' => ['The email has already been taken.']]);
    }

    public function testPutVendedor(): void
    {
        $vendedor = Vendedor::factory()->create();

        $response = $this->actingAs($this->user)->put('/api/vendedor/' . $vendedor->id, [
            'nome' => fake()->name(),
        ]);

        $response->assertNoContent();
    }

    public function testPutVendedorWithoutName(): void
    {
        $vendedor = Vendedor::factory()->create();

        $response = $this->actingAs($this->user)->put('/api/vendedor/' . $vendedor->id, [
            'nome' => '',
        ]);

        $response->assertStatus(422);
        $response->assertExactJson(['nome' => ['The nome field is required.']]);
    }

    public function testPatchVendedor(): void
    {
        $vendedor = Vendedor::factory()->create();

        $response = $this->actingAs($this->user)->put('/api/vendedor/' . $vendedor->id, [
            'nome' => fake()->name(),
        ]);

        $response->assertNoContent();
    }

    public function testPatchVendedorWithoutName(): void
    {
        $vendedor = Vendedor::factory()->create();

        $response = $this->actingAs($this->user)->put('/api/vendedor/' . $vendedor->id, [
            'nome' => '',
        ]);

        $response->assertStatus(422);
        $response->assertExactJson(['nome' => ['The nome field is required.']]);
    }

    public function testDeleteVendedor(): void
    {
        $vendedor = Vendedor::factory()->create();

        $response = $this->actingAs($this->user)->delete('/api/vendedor/' . $vendedor->id);

        $response->assertNoContent();
    }
}
