<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Venda;
use App\Models\Vendedor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VendedorMailTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function testEmailLoteWithoutVenda(): void
    {
        Vendedor::factory()->create();
        Venda::truncate();

        $response = $this->actingAs($this->user)->get('/api/vendedor/email');
        $response->assertStatus(201);
    }

    public function testEmailVendedorWithoutVenda(): void
    {
        $vendedor = Vendedor::factory()->create();

        $response = $this->actingAs($this->user)->get('/api/vendedor/' . $vendedor->id . '/email');

        $response->assertStatus(201);
    }

    public function testEmailVendedor(): void
    {
        $vendedor = Vendedor::factory()->create();
        Venda::factory(10)->create([
            'vendedor_id' => $vendedor->id,
            'data_venda' => date('Y-m-d H:i:s'),
        ]);

        $response = $this->actingAs($this->user)->get('/api/vendedor/' . $vendedor->id . '/email');

        $response->assertStatus(201);
    }

    public function testEmailLote(): void
    {
        $vendedor = Vendedor::factory()->create();
        Venda::factory(10)->create([
            'vendedor_id' => $vendedor->id,
            'data_venda' => date('Y-m-d H:i:s'),
        ]);

        $vendedor2 = Vendedor::factory()->create();
        Venda::factory(10)->create([
            'vendedor_id' => $vendedor2->id,
            'data_venda' => date('Y-m-d H:i:s'),
        ]);

        $response = $this->actingAs($this->user)->get('/api/vendedor/email');
        $response->assertStatus(201);
    }
}
