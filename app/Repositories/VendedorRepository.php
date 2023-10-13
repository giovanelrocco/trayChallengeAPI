<?php

namespace App\Repositories;

use App\Models\Vendedor;
use App\Repositories\VendaRepository;
use Illuminate\Support\Facades\DB;

class VendedorRepository
{
    private $model;
    protected $venda_repository;

    public function __construct(Vendedor $model, VendaRepository $venda_repository)
    {
        $this->model = $model;
        $this->venda_repository = $venda_repository;
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
        try
        {
            DB::beginTransaction();
            $this->venda_repository->destroyByVendedor($id);
            $result = Vendedor::find($id)->delete();
            DB::commit();

            return $result;
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            throw new \Exception('Erro ao deletar a informação');
        }
    }
}
