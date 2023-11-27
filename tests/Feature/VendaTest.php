<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Venda;
use App\Models\Vendedor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VendaTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function testRotasProtegida(): void
    {
        $venda = Venda::factory()->create();

        $this->get('/api/venda')->assertStatus(500);
        $this->get('/api/venda/' . $venda->id)->assertStatus(500);
        $this->post('/api/venda', [])->assertStatus(500);
    }

    public function testGetVendas(): void
    {
        Venda::factory(10)->create();

        $response = $this->actingAs($this->user)->get('/api/venda');

        $response->assertStatus(200);
        $response->assertJsonStructure(array(
            'data' => array(),
            'links' => array(),
            'meta' => array(),
        ));
        // $response->data->assertJsonIsArray();
        // $response->data->assertJsonCount(10);
    }

    public function testGetVendasByVendedor(): void
    {
        $vendedor = Vendedor::factory()->create();
        $vendedor_nao_mostrar = Vendedor::factory()->create();

        Venda::factory(10)->create([
            'vendedor_id' => $vendedor->id,
        ]);

        Venda::factory(10)->create([
            'vendedor_id' => $vendedor_nao_mostrar->id,
        ]);

        $response = $this->actingAs($this->user)->get('/api/vendedor/' . $vendedor->id . '/venda');

        $response->assertStatus(200);
        $response->assertJsonStructure(array(
            'data' => array(),
            'links' => array(),
            'meta' => array(),
        ));
        // $response->assertJsonIsArray();
        // $response->assertJsonCount(10);
    }

    public function testGetVenda(): void
    {
        $venda = Venda::factory()->create();

        $response = $this->actingAs($this->user)->get('/api/venda/' . $venda->id);

        $response->assertStatus(200);
        $response->assertExactJson($venda->toArray());
    }

    public function testGetVendaNotFound(): void
    {
        $response = $this->actingAs($this->user)->get('/api/venda/100000000');

        $response->assertStatus(404);
        $response->assertSeeText('Venda não encontrada');
    }

    public function testPostVenda(): void
    {
        $vendedor = Vendedor::factory()->create();

        $response = $this->actingAs($this->user)->post('/api/venda', [
            'vendedor_id' => $vendedor->id,
            'valor' => fake()->randomFloat(2, 1, 999999),
            'data_venda' => fake()->date() . ' ' . fake()->time(),
        ]);

        $response->assertCreated();
    }

    public function testPostVendaWithoutVendedor(): void
    {
        $response = $this->actingAs($this->user)->post('/api/venda', [
            'vendedor_id' => '',
            'valor' => fake()->randomFloat(2, 1, 999999),
            'data_venda' => fake()->date() . ' ' . fake()->time(),
        ]);

        $response->assertStatus(422);
        $response->assertExactJson(['vendedor_id' => ['The vendedor id field is required.']]);
    }

    public function testPostVendedorWithoutValor(): void
    {
        $vendedor = Vendedor::factory()->create();

        $response = $this->actingAs($this->user)->post('/api/venda', [
            'vendedor_id' => $vendedor->id,
            'valor' => '',
            'data_venda' => fake()->date() . ' ' . fake()->time(),
        ]);

        $response->assertStatus(422);
        $response->assertExactJson(['valor' => ['The valor field is required.']]);
    }
}
