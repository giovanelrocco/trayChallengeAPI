<?php

namespace App\Repositories;

use App\Models\Venda;

class VendaRepository
{
    private $model;

    public function __construct(Venda $model)
    {
        $this->model = $model;
    }

    public function list()
    {
        return $this->model->all();
    }

    public function listByVendedor(int $vendedor_id)
    {
        return $this->model->where('vendedor_id', '=', $vendedor_id)->get();
    }

    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    public function save(array $data = [])
    {
        $venda = new Venda;
        $venda->vendedor_id = $data['vendedor_id'];
        $venda->valor = $data['valor'];
        $venda->data_venda = $data['data_venda'];

        $venda->save();

        return $venda;
    }
}
