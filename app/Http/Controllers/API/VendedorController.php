<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\VendedorResource;
use App\Services\VendedorService;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;

class VendedorController extends Controller
{
    use HasApiTokens;

    protected $service;

    public function __construct(VendedorService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $vendedores = $this->service->list();
        return VendedorResource::collection($vendedores);
    }

    public function show(int $id)
    {
        $vendedor = $this->service->findById($id);

        if (!$vendedor) {
            return response('Vendedor não encontrado.', 404);
        }

        return new VendedorResource($vendedor);
    }

    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'nome' => 'required',
                'email' => 'required|unique:App\Models\Vendedor',
            ]);
        } catch (\Illuminate\Validation\ValidationException $th) {
            return response($th->validator->errors(), 422);
        }

        $this->service->save($request->all());
        return response('', 201)
            ->header('Content-Type', 'application/json');
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'nome' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $th) {
            return response($th->validator->errors(), 422);
        }

        $this->service->update($request->id, $request->all());

        return response('', 204)
            ->header('Content-Type', 'application/json');

    }

    public function delete(Request $request)
    {
        $this->service->destroyById($request->id);

        return response('', 204)
            ->header('Content-Type', 'application/json');

    }
}
