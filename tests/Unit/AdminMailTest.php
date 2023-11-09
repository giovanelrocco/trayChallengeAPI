<?php

namespace Tests\Unit;

use App\Mail\AdminMail;
use App\Models\Venda;
use App\Models\Vendedor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMailTest extends TestCase
{
    use RefreshDatabase;

    public function testVendedorEmail(): void
    {
        $vendedor = Vendedor::factory()->create();
        $vendas = Venda::factory(10)->create([
            'vendedor_id' => $vendedor->id,
            'data_venda' => date('Y-m-d H:i:s'),
        ]);

        $mailable = new AdminMail($vendas);

        $mailable->assertHasSubject('Vendas do dia');
        $mailable->assertSeeInHtml('Relatório diário de Comissão');
        $mailable->assertSeeInOrderInHtml(['Olá, este é seu relatório de vendas do dia', date('d/m/Y')]);
        $mailable->assertSeeInHtml('Total');
    }
}
