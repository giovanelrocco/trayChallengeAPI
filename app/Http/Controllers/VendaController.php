<?php

namespace App\Http\Controllers;

use App\Repositories\VendaRepository;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    protected $repository;

    public function __construct(VendaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $vendas = $this->repository->list();
        return response()->json($vendas);
    }

    public function indexByVendedor(Request $request)
    {
        $vendas = $this->repository->listByVendedor($request->vendedor_id);
        return response()->json($vendas);
    }

    public function show(int $id)
    {
        $venda = $this->repository->findById($id);
        // $venda->vendedor;

        if (!$venda) {
            throw new \Exception('Venda não encontrada');
        }

        return response()->json($venda);
    }

    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'vendedor_id' => 'required|exists:vendedor,id',
                'valor' => 'required',
                'data_venda' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $th) {
            return response($th->validator->errors(), 422);
        }

        $this->repository->save($request->all());
        return response('', 201)
            ->header('Content-Type', 'application/json');
    }
}
