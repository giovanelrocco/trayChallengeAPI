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
        return $this->model->paginate(20);
    }

    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    public function save(array $data = [])
    {
        try {
            DB::beginTransaction();
            $vendedor = new Vendedor($data);
            $vendedor->save();
            DB::commit();

            return $vendedor;
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            throw new \App\Exceptions\VendedorException('Erro ao salvar o vendedor');
        }
    }

    public function update(int $id, array $data = [])
    {
        try
        {
            DB::beginTransaction();
            $vendedor = Vendedor::find($id);
            $vendedor->nome = $data['nome'];
            $vendedor->save();
            DB::commit();

            return $vendedor;
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            throw new \App\Exceptions\VendedorException('Erro ao atualizar o vendedor');
        }
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
            throw new \App\Exceptions\VendedorException('Erro ao deletar o vendedor');
        }
    }
}
