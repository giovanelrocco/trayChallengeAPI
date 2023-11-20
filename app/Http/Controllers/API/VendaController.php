<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\VendaResource;
use App\Services\VendaService;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    protected $service;

    public function __construct(VendaService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $vendas = $this->service->list();
        return VendaResource::collection($vendas);
    }

    public function indexByVendedor(Request $request)
    {
        $vendas = $this->service->listByVendedor($request->vendedor_id);
        return VendaResource::collection($vendas);
    }

    public function show(int $id)
    {
        $venda = $this->service->findById($id);

        if (!$venda) {
            return response('Venda não encontrada.', 404);
        }

        return new VendaResource($venda);
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

        $this->service->save($request->all());
        return response('', 201)
            ->header('Content-Type', 'application/json');
    }
}
