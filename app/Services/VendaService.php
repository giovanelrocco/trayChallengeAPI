<?php

namespace App\Services;

use App\Repositories\VendaRepository;

class VendaService
{

    protected $repository;

    public const PERCENTUAL_COMISSAO = 8.5;

    public function __construct(VendaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function list()
    {
        return $this->repository->list();
    }

    public function listByVendedor(int $vendedor_id)
    {
        return $this->repository->listByVendedor($vendedor_id);
    }

    public function save(array $data)
    {
        $data['comissao'] = round(($this::PERCENTUAL_COMISSAO / 100) * $data['valor'], 2);
        $data['percentual_comissao'] = $this::PERCENTUAL_COMISSAO;

        return $this->repository->save($data);
    }

}
