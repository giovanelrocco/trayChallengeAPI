<?php

namespace Tests\Unit;

use App\Mail\VendedorMail;
use App\Models\Venda;
use App\Models\Vendedor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VendedorMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_vendedor_email(): void
    {
        $vendedor = Vendedor::factory()->create();
        $vendas = Venda::factory(10)->create([
            'vendedor_id' => $vendedor->id,
            'data_venda' => date('Y-m-d H:i:s'),
        ]);

        $mailable = new VendedorMail($vendas->toArray(), $vendedor->toArray());

        $mailable->assertHasSubject('Vendas do dia');
        $mailable->assertSeeInHtml($vendedor->nome);
        $mailable->assertSeeInHtml('Relatório diário de Comissão');
        $mailable->assertSeeInHtml('A sua comissão foi de');
        $mailable->assertSeeInHtml(date('d/m/Y'));
        $mailable->assertSeeInHtml('Total');
    }
}
