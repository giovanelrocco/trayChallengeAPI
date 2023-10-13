<?php

namespace Tests\Feature;

use App\Models\Venda;
use App\Models\Vendedor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VendaTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_vendas(): void
    {
        Venda::factory(10)->create();

        $response = $this->get('/api/venda');

        $response->assertStatus(200);
        $response->assertJsonIsArray();
        $response->assertJsonCount(10);
    }

    public function test_get_vendas_by_vendedor(): void
    {
        $vendedor = Vendedor::factory()->create();
        $vendedor_nao_mostrar = Vendedor::factory()->create();

        Venda::factory(10)->create([
            'vendedor_id' => $vendedor->id,
        ]);

        Venda::factory(10)->create([
            'vendedor_id' => $vendedor_nao_mostrar->id,
        ]);

        $response = $this->get('/api/vendedor/' . $vendedor->id . '/venda');

        $response->assertStatus(200);
        $response->assertJsonIsArray();
        $response->assertJsonCount(10);
    }

    public function test_get_venda(): void
    {
        $venda = Venda::factory()->create();

        $response = $this->get('/api/venda/' . $venda->id);

        $response->assertStatus(200);
        $response->assertSimilarJson($venda->toArray());
    }

    public function test_post_venda(): void
    {
        $vendedor = Vendedor::factory()->create();

        $response = $this->post('/api/venda', [
            'vendedor_id' => $vendedor->id,
            'valor' => fake()->randomFloat(2, 1, 999999),
            'data_venda' => fake()->date() . ' ' . fake()->time(),
        ]);

        $response->assertCreated();
    }

    public function test_post_venda_without_vendedor(): void
    {
        $response = $this->post('/api/venda', [
            'vendedor_id' => '',
            'valor' => fake()->randomFloat(2, 1, 999999),
            'data_venda' => fake()->date() . ' ' . fake()->time(),
        ]);

        $response->assertStatus(422);
        $response->assertExactJson(['vendedor_id' => ['The vendedor id field is required.']]);
    }

    public function test_post_vendedor_without_valor(): void
    {
        $vendedor = Vendedor::factory()->create();

        $response = $this->post('/api/venda', [
            'vendedor_id' => $vendedor->id,
            'valor' => '',
            'data_venda' => fake()->date() . ' ' . fake()->time(),
        ]);

        $response->assertStatus(422);
        $response->assertExactJson(['valor' => ['The valor field is required.']]);
    }
}
