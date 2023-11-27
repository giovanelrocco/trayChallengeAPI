<?php

namespace Tests\Unit;

use App\Exceptions\VendedorException;
use App\Models\Venda;
use App\Models\Vendedor;
use App\Repositories\VendaRepository;
use App\Repositories\VendedorRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VendedorRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new VendedorRepository(new Vendedor(), new VendaRepository(new Venda()));
    }

    public function testEmptyList()
    {
        Venda::truncate();
        Vendedor::truncate();

        $response = $this->repository->list();

        $this->assertCount(0, $response);
    }

    public function testList()
    {
        Vendedor::factory(10)->create();

        $response = $this->repository->list();

        $this->assertCount(10, $response);
    }

    public function testFindById()
    {
        $vendedores = Vendedor::factory(3)->create();

        $response = $this->repository->findById($vendedores[0]->id);

        $this->assertEquals($vendedores[0]->id, $response->id);
        $this->assertEquals($vendedores[0]->nome, $response->nome);
        $this->assertEquals($vendedores[0]->email, $response->email);
    }

    public function testSave(array $data = [])
    {
        $vendedor = [
            'nome' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
        ];

        $this->repository->save($vendedor);

        $this->assertDatabaseHas('vendedor', $vendedor);
    }

    public function testErrorSave(array $data = [])
    {
        $this->expectException(VendedorException::class);

        $this->repository->save([]);
    }

    public function testUpdate(array $data = [])
    {
        $vendedor = Vendedor::factory()->create();

        $response = $this->repository->update($vendedor->id, [
            'nome' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
        ]);
        unset($response->created_at);
        unset($response->updated_at);

        $this->assertDatabaseHas('vendedor', $response->toArray());
    }

    // public function testErrorUpdate()
    // {
    //     $this->expectException(VendedorException::class);

    //     $vendedor = Vendedor::factory()->create();
    //     Vendedor::truncate();

    //     $this->repository->update($vendedor->id, [
    //         'nome' => '',
    //     ]);
    // }

    public function testDestroyById()
    {
        $vendedor = Vendedor::factory()->create();

        $this->repository->destroyById($vendedor->id);

        $this->assertDatabaseMissing('vendedor', $vendedor->toArray());
    }

    // public function testErrorDestroyById()
    // {
    //     $vendedor = Vendedor::factory()->create();
    //     Vendedor::truncate();

    //     $this->expectException(VendedorException::class);

    //     $this->repository->destroyById($vendedor->id);
    // }
}
