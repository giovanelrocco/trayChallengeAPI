<?php

namespace App\Repositories;

use App\Models\Venda;
use Illuminate\Support\Facades\DB;

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

    public function listVendedoresByData()
    {
        return $this
            ->model
            ->select('vendedor_id')
            ->where('data_venda', 'LIKE', date("Y-m-d") . '%')
            ->groupBy('vendedor_id')
            ->get();
    }

    public function listByData()
    {
        return $this
            ->model
            ->where('data_venda', 'LIKE', date("Y-m-d") . '%')
            ->get();
    }

    public function listByVendedorAndData(int $vendedor_id)
    {
        return $this
            ->model
            ->where('vendedor_id', '=', $vendedor_id)
            ->where('data_venda', 'LIKE', date("Y-m-d") . '%')
            ->get();
    }

    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    public function save(array $data = [])
    {
        try {
            DB::beginTransaction();
            $venda = new Venda($data);
            $venda->save();
            DB::commit();

            return $venda;
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            throw new \App\Exceptions\VendaException('Erro ao salvar o vendedor.');
        }
    }

    public function destroyByVendedor(int $vendedor_id)
    {
        return $this->model->where('vendedor_id', '=', $vendedor_id)->delete();
    }
}
