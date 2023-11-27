<?php

namespace Tests\Unit;

use App\Exceptions\VendaException;
use App\Models\Venda;
use App\Models\Vendedor;
use App\Repositories\VendaRepository;
use App\Services\VendaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VendaRepositoryTest extends TestCase
{

    use RefreshDatabase;

    private $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new VendaRepository(new Venda());
    }

    public function testEmptyList(): void
    {
        Venda::truncate();

        $response = $this->repository->list();

        $this->assertCount(0, $response);
    }

    public function testList(): void
    {
        Venda::factory(10)->create();

        $response = $this->repository->list();

        $this->assertCount(10, $response);
    }

    public function testListByVendedor(): void
    {
        $vendas = Venda::factory(3)->create();

        $response = $this->repository->listByVendedor($vendas[0]->vendedor_id);

        $this->assertCount(1, $response);
    }

    public function testListVendedoresByData(): void
    {
        Venda::factory(5)->create();
        $vendas = Venda::factory(5)->create([
            'data_venda' => date("Y-m-d H:i:s"),
        ]);

        $response = $this->repository->listVendedoresByData();

        $this->assertCount(5, $response);
    }

    public function testListByData(): void
    {
        Venda::factory(5)->create();
        Venda::factory(5)->create([
            'data_venda' => date("Y-m-d H:i:s"),
        ]);

        $response = $this->repository->listByData();

        $this->assertCount(5, $response);
    }

    public function testFindById(): void
    {
        $vendas = Venda::factory(3)->create();

        $response = $this->repository->findById($vendas[0]->id);

        $this->assertEquals($vendas[0]->id, $response->id);
        $this->assertEquals($vendas[0]->vendedor_id, $response->vendedor_id);
        $this->assertEquals($vendas[0]->valor, $response->valor);
        $this->assertEquals($vendas[0]->data_venda, $response->data_venda);
        $this->assertEquals($vendas[0]->comissao, $response->comissao);
    }

    public function testSave(): void
    {
        $vendedor = Vendedor::factory()->create();
        $valor = fake()->randomFloat(2, 1, 999999);
        $venda = [
            'vendedor_id' => $vendedor->id,
            'valor' => $valor,
            'data_venda' => fake()->date() . ' ' . fake()->time(),
            'comissao' => round((VendaService::PERCENTUAL_COMISSAO / 100) * $valor, 2),
            'percentual_comissao' => VendaService::PERCENTUAL_COMISSAO,
        ];

        $this->repository->save($venda);

        $this->assertDatabaseHas('venda', $venda);
    }

    public function testSaveWithoutVendedor(): void
    {
        $this->expectException(VendaException::class);

        $valor = fake()->randomFloat(2, 1, 999999);
        $venda = [
            'vendedor_id' => '',
            'valor' => $valor,
            'data_venda' => fake()->date() . ' ' . fake()->time(),
            'comissao' => round((VendaService::PERCENTUAL_COMISSAO / 100) * $valor, 2),
            'percentual_comissao' => VendaService::PERCENTUAL_COMISSAO,
        ];

        $this->repository->save($venda);
    }

    public function testDestroyByVendedor(): void
    {
        $venda = Venda::factory()->create();

        $this->repository->destroyByVendedor($venda->vendedor_id);

        $this->assertDatabaseMissing('venda', $venda->toArray());
    }
}
