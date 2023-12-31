<?php

namespace App\Services;

use App\Repositories\VendaRepository;
use App\Repositories\VendedorRepository;
use Illuminate\Support\Facades\Mail;

class MailService
{

    protected $repository;
    protected $vendedor_repository;

    public function __construct(VendaRepository $repository, VendedorRepository $vendedor_repository)
    {
        $this->repository = $repository;
        $this->vendedor_repository = $vendedor_repository;
    }

    public function enviarEmailAdmin()
    {
        $vendas = $this->repository->listByData();

        if (count($vendas) < 1) {
            return response('Venda não encontrada.', 404);
        }

        Mail::to(env('ADMIN_EMAIL', 'test@gmail.com'))->send(new \App\Mail\AdminMail($vendas));

    }

    public function enviarLoteEmail()
    {
        $vendedores_com_venda = $this->repository->listVendedoresByData()->toArray();

        if (!$vendedores_com_venda) {
            return response('Sem venda no dia corrente.', 404);
        }

        foreach ($vendedores_com_venda as $vendedor) {
            $this->programarEmail($vendedor['vendedor_id']);
        }

        return response('', 201)
            ->header('Content-Type', 'application/json');

    }

    public function enviarEmail(int $vendedor_id)
    {

        $this->programarEmail($vendedor_id);

        return response('', 201)
            ->header('Content-Type', 'application/json');
    }

    public function programarEmail(int $vendedor_id)
    {
        $vendas = $this->repository->listByVendedorAndData($vendedor_id);

        if (count($vendas) < 1) {
            return response('Venda não encontrada.', 404);
        }

        $vendedor = $this->vendedor_repository->findById($vendedor_id);

        if (!$vendedor) {
            return response('Vendedor não encontrada.', 404);
        }

        Mail::to($vendedor->email)->send(new \App\Mail\VendedorMail($vendas->toArray(), $vendedor->toArray()));
    }
}
