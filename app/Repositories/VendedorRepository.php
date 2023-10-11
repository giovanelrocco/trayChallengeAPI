<?php

namespace App\Repositories;

use App\Models\Vendedor;

class VendedorRepository
{
    private $model;

    public function __construct(Vendedor $model)
    {
        $this->model = $model;
    }

    public function list()
    {
        return $this->model->all();
    }

    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    public function saveOrUpdate(int $id = null, array $data = [])
    {
        if (is_null($id)) {
            $vendedor = new Vendedor;
            $vendedor->nome = $data['nome'];
            $vendedor->email = $data['email'];
        } else {
            $vendedor = Vendedor::find($id);
            $vendedor->nome = $data['nome'];
        }

        $vendedor->save();

        return $vendedor;
    }

    public function destroyById(int $id)
    {
        return Vendedor::find($id)->delete();
    }
}
